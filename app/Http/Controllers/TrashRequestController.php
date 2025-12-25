<?php

namespace App\Http\Controllers;

use App\Models\TrashRequest;
use App\Models\TrashRequestHistory;
use App\Models\TrashRequestFile;
use App\Models\TrashLocation;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Controllers\LineMessagingController;

class TrashRequestController extends Controller
{
    protected $lineUserId = 'Ub91fe7b9c20a526daf3e7e4d94e75816'; // User ID

    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_1' => 'required|string',
            'field_2' => 'required|string',
            'field_3' => 'required|digits:10',
            'field_7' => 'required|string',
            'field_9' => 'required|string',
            'field_10' => 'required|string',
            'field_11' => 'required|string',
        ]);

        $requestData = [
            'prefix' => $validated['field_1'],
            'fullname' => $validated['field_2'],
            'age' => $request->field_5,
            'nationality' => $request->field_6,
            'tel' => $validated['field_3'],
            'house_no' => $validated['field_7'],
            'village_no' => $request->field_8,
            'subdistrict' => $validated['field_9'],
            'district' => $validated['field_10'],
            'province' => $validated['field_11'],
            'road' => $request->field_15,
            'alley' => $request->field_14,
            'type' => $request->type,
            'status' => 'รอรับเรื่อง',
            'creator_id' => auth()->id(),
            'id_card' => $request->field_16,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ];

        if ($request->has('addon')) {
            $requestData['addon'] = json_encode($request->addon, JSON_UNESCAPED_UNICODE);
        }

        $trashRequest = TrashRequest::create($requestData);

        // เก็บไฟล์เหมือนเดิม
        $fileInputs = ['files1','files2','files3','files4','files4_1','files4_2','files4_3','files4_4','files4_5','files5','files6','files7','files8'];
        foreach ($fileInputs as $field) {
            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('trash_pictures', $filename, 'public');

                        \App\Models\TrashRequestFile::create([
                            'trash_request_id' => $trashRequest->id,
                            'field_name' => $field,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                        ]);
                    }
                }
            }
        }

        // ส่ง LINE ให้เฉพาะผู้ใช้งานปัจจุบันที่มี line_user_id
        $user = auth()->user();
        if ($user && $user->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);

            $lineMessage = "คำร้องของคุณถูกสร้างเรียบร้อย\nประเภท: {$typeTitle}\nสถานะ: {$trashRequest->status}\nดูรายละเอียด: " . url("user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $lineController = new LineMessagingController();
            $lineController->pushMessage($user->line_user_id, $lineMessage);
        }

        // ========================================
        // 🔔 ส่ง LINE ให้ admin ตามประเภทคำร้อง
        // ========================================
        $typeTitle = getTrashRequestTypeTitle($trashRequest->type);

        $adminMessage = "📢 มีคำร้องขอ {$typeTitle} เข้ามา\n"
            . "จาก {$trashRequest->fullname}\n"
            . "กรุณาตรวจสอบ\n"
            . "ดูรายละเอียด: "
            . url("admin/request/{$trashRequest->type}/{$trashRequest->id}");

        $lineController = new LineMessagingController();

        // -------------------------
        // ตรวจสอบ type เพื่อเลือก admin
        // -------------------------
        if (Str::contains($trashRequest->type, 'engineer')) {

            // ▶ admin-engineer
            $admins = User::where('role', 'admin-engineer')
                ->whereNotNull('line_user_id')
                ->get();

        } elseif ($trashRequest->type === 'trash-request') {

            // ▶ admin-trash
            $admins = User::where('role', 'admin-trash')
                ->whereNotNull('line_user_id')
                ->get();

        } else {

            // ▶ admin-health
            $admins = User::where('role', 'admin-health')
                ->whereNotNull('line_user_id')
                ->get();
        }

        // -------------------------
        // ส่ง LINE
        // -------------------------
        foreach ($admins as $admin) {
            $lineController->pushMessage($admin->line_user_id, $adminMessage);
        }

        return redirect()->back()->with('success', 'บันทึกคำขอเรียบร้อยแล้วและส่ง LINE เรียบร้อยแล้ว!');
    }

    public function showData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('data_table_length', 10);

        $trashRequests = TrashRequest::with(['receiver:id,name', 'files'])
            ->where('type', 'trash-request')
            ->when($search, function ($query, $search) {
                $query->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhereHas('receiver', function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['search' => $search, 'data_table_length' => $perPage]);

        $histories = TrashRequestHistory::with('responder:id,name')->get();

        $modified = $trashRequests->getCollection()->map(function ($request) use ($histories) {
            $requestHistories = $histories->where('trash_request_id', $request->id)
                ->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                })->values();

            $request->fullname = $request->fullname ?? $request->name ?? '-';
            $request->receiver_name = $request->receiver->name ?? '-';
            $request->histories = $requestHistories;
            $request->picture_path = $request->files->pluck('file_path')->toArray();

            return $request;
        });

        $trashRequests->setCollection($modified);

        return view('admin_trash.showdata', compact('trashRequests', 'search', 'perPage'));
    }


    public function showDataRequestHealth($type)
    {
        $trashRequests = TrashRequest::with('receiver:id,name', 'files')
            ->where('type', $type)
            ->where('status', 'รอรับเรื่อง')
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = TrashRequestHistory::with('responder:id,name')
            ->get()
            ->groupBy('trash_request_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                });
            });

        return view('admin_request.public-health.showdata', compact('trashRequests', 'histories', 'type'));
    }

    public function showDataRequestEngineer($type)
    {
        $trashRequests = TrashRequest::with('receiver:id,name', 'files')
            ->where('type', $type)
            ->where('status', 'รอรับเรื่อง')
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = TrashRequestHistory::with('responder:id,name')
            ->get()
            ->groupBy('trash_request_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                });
            });

        return view('admin_request.engineering.showdata', compact('trashRequests', 'histories', 'type'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:trash_requests,id',
            'message' => 'required|string',
            'user_id' => 'required|integer'
        ]);

        TrashRequestHistory::create([
            'trash_request_id' => $request->request_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);
        
        // ส่ง LINE แจ้งผู้สร้างคำขอ
        $trashRequest = TrashRequest::find($request->request_id);
        if ($trashRequest && $trashRequest->creator && $trashRequest->creator->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
            $lineMessage = "มีข้อความตอบกลับคำร้องของคุณ\nประเภท: {$typeTitle}\nข้อความ: {$request->message}\nดูรายละเอียด: " . url("/user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $lineController = new LineMessagingController();
            $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
        }
        return response()->json(['success' => true]);
    }


    public function accept(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:trash_requests,id',
            'user_id' => 'required|integer',
        ]);

        $trashRequest = TrashRequest::findOrFail($request->request_id);
        $user = $request->user_id;

        if ($trashRequest->type === 'trash-request') {
            // อัปเดตสถานะคำขอ
            $trashRequest->status = 'เสร็จสิ้น';
            $trashRequest->receiver_id = $user;
            $trashRequest->received_at = now();
            $trashRequest->save();

            // ✅ เพิ่มข้อมูลในตาราง trash_locations
            $location = new \App\Models\TrashLocation();
            $location->name = $trashRequest->fullname;
            $location->address = trim($trashRequest->house_no . ' ' . $trashRequest->subdistrict . ' ' . $trashRequest->district . ' ' . $trashRequest->province);
            $location->status = 'รออนุมัติเรียกชำระเงิน';
            $location->tel = $trashRequest->tel ?? null;
            $location->user_id = $trashRequest->creator_id;
            $location->save();

            // ✅ บันทึก id ของ trash_location กลับไปที่ trash_request ในช่อง addon
            $trashRequest->trash_location_id = $location->id;
            $trashRequest->save();

            $bill = new \App\Models\Bill();
            $bill->trash_location_id = $location->id;
            $bill->user_id = $trashRequest->creator_id;
            $bill->amount = 20;
            $bill->status = 'ยังไม่ชำระ';
            $bill->due_date = now()->addDays(7); // กำหนดครบกำหนดอีก 7 วัน
            $bill->save();
        } else {
            $trashRequest->status = 'รอการนัดหมาย';
            $trashRequest->receiver_id = $user;
            $trashRequest->received_at = now();
            $trashRequest->save();
        }

        // ส่ง LINE แจ้งผู้สร้างคำขอ
        if ($trashRequest->creator && $trashRequest->creator->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
            $lineMessage = "คำร้องของคุณถูกอัปเดตเรียบร้อย\nประเภท: {$typeTitle}\nสถานะ: {$trashRequest->status}\nดูรายละเอียด: " . url("/user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $lineController = new LineMessagingController();
            $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
        }


        return response()->json(['success' => true]);
    }

    
    public function showPdfTrash($id)
    {

        // ดึง TrashRequest พร้อมไฟล์
        $trashRequest = TrashRequest::with('files')->findOrFail($id);

        // วัน เดือน ปี ภาษาไทย
        $date = \Carbon\Carbon::parse($trashRequest->created_at ?? now());
        $day = (int) $date->format('d');
        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $month = $thaiMonths[(int)$date->format('m')];
        $year = $date->format('Y') + 543;
        $addon = json_decode($trashRequest->addon, true);
        if (!empty($addon['payment']['submitted_at'])) {
            $submittedAt = Carbon::parse($addon['payment']['submitted_at']);
            $dayPayment = $submittedAt->format('d'); // เอาแค่วัน
            $monthPayment = $thaiMonths[(int)$submittedAt->format('m')];
            $yearPayment = $submittedAt->format('Y') + 543;
        } else {
            $dayPayment = '-';
            $monthPayment = '-';
            $yearPayment = '-';
        } 
        if (!empty($addon['license_issued_at'])) {
            $licenseAt = Carbon::parse($addon['license_issued_at']);
            $daylicenseAt = (int) $licenseAt->format('d'); // เอาแค่วัน
            $monthlicenseAt = $thaiMonths[(int)$licenseAt->format('m')];
            $yearlicenseAt = $licenseAt->format('Y') + 543;

            $expireAt = Carbon::parse($addon['license_expire_at']);
            $dayexpireAt = (int) $expireAt->format('d'); // เอาแค่วัน
            $monthexpireAt = $thaiMonths[(int)$expireAt->format('m')];
            $yearexpireAt = $expireAt->format('Y') + 543;
        } else {
            $daylicenseAt = '';
            $monthlicenseAt = '';
            $yearlicenseAt = '';

            $dayexpireAt = '';
            $monthexpireAt = '';
            $yearexpireAt = '';
        }  

        if (!empty($addon['at1'])) {
            $at1 = Carbon::parse($addon['at1']);
            $dayat1 = (int) $at1->format('d'); // เอาแค่วัน
            $monthat1 = $thaiMonths[(int)$at1->format('m')];
            $yearat1 = $at1->format('Y') + 543;

        } else {
            $dayat1 = '';
            $monthat1 = '';
            $yearat1 = '';
        }  

        if (!empty($addon['endat'])) {
            $endat = Carbon::parse($addon['endat']);
            $dayendat = (int) $endat->format('d'); // เอาแค่วัน
            $monthendat = $thaiMonths[(int)$endat->format('m')];
            $yearendat = $endat->format('Y') + 543;

        } else {
            $dayendat = '';
            $monthendat = '';
            $yearendat = '';
        }  
        
        if (!empty($addon['license_issued_by'])) {
            $user = User::find($addon['license_issued_by']);
            if ($user) {
                $licenseIssuedBy = $user->name; // หรือฟิลด์อื่น ๆ เช่น fullname
            }
        }
        
        // Mapping fields สำหรับ PDF
        $fields = [
            'field_1' => $trashRequest->fullname ?? '-',
            'field_2' => $trashRequest->prefix ?? '-',
            'field_3' => $trashRequest->age ?? '-',
            'field_4' => $trashRequest->nationality ?? '-',
            'field_5' => $trashRequest->id_card ?? '-',
            'field_6' => $trashRequest->alley ?? '-',
            'field_7' => $trashRequest->road ?? '-',
            'field_8' => $trashRequest->house_no ?? '-',
            'field_9' => $trashRequest->village_no ?? '-',
            'field_10' => $trashRequest?->subdistrict ?? '-',
            'field_11' => $trashRequest?->district ?? '-',
            'field_12' => $trashRequest?->province ?? '-',
            'field_13' => $trashRequest?->tel ?? '-',
            'field_14' => $trashRequest?->fax ?? '-',
            'field_15' => $addon['personal'] ?? '-',
            'field_16' => $addon['payment']['amount'] ?? '-',
            'field_17' => $dayPayment ?? '-',
            'field_18' => $monthPayment ?? '-',
            'field_19' => $yearPayment ?? '-',
            'field_20' => $addon['individual']['type'] ?? '-',
            'field_21' => $addon['individual']['room_count'] ?? '-',
            'field_22' => $addon['individual']['home_rent'] ?? '-',
            'field_23' => $addon['individual']['home_rent'] ?? '-',
            'field_24' => $addon['corporation']['type'] ?? '-',
            'field_25' => $addon['corporation']['worker_count'] ?? '-',
            'field_26' => $addon['corporation']['machine_power'] ?? '-',
            'field_27' => $daylicenseAt ?? '',
            'field_28' => $monthlicenseAt ?? '',
            'field_29' => $yearlicenseAt ?? '',
            'field_30' => $dayexpireAt ?? '',
            'field_31' => $monthexpireAt ?? '',
            'field_32' => $yearexpireAt ?? '',
            'field_33' => $licenseIssuedBy ?? '',
            'field_34' => $addon["name"] ?? '-',
            'field_35'=> $addon["area"] ?? '-',
            'field_36'=> $addon["house_no"] ?? null,
            'field_37'=> $addon["alley"] ?? '',
            'field_38'=> $addon["road"] ?? '',
            'field_39'=> $addon["village_no"] ?? '',
            'field_40'=> $addon["tel"] ?? '',
            'field_41'=> $addon["year"] ?? '',
            'field_42'=> $addon["subdistrict"] ?? '',
            'field_43'=> $addon["district"] ?? '',
            'field_44'=> $addon["province"] ?? '',
            'field_45'=> $addon["at"] ?? '-',
            'field_46'=> $addon["license_no1"] ?? '',
            'field_47'=> $addon["at1"] ?? '-',
            'field_48'=> $addon["home_no1"] ?? '-',
            'field_49'=> $addon["alley1"] ?? '-',
            'field_50'=> $addon["road1"] ?? '-',
            'field_51'=> $addon["village_no1"] ?? '-',
            'field_52' => $addon['individual']['card_id'] ?? '-',
            'field_53' => $addon['postcode'] ?? '-',
            'field_54' => $addon['corporation']['postcode'] ?? '-',
            'field_55' => $addon['corporation']['corp_registered_at'] ?? '-',
            'field_56' => $addon['corporation']['corp_home_no'] ?? '-',
            'field_57' => $addon['corporation']['alley'] ?? '-',
            'field_58' => $addon['corporation']['road'] ?? '-',
            'field_59' => $addon['corporation']['corp_village_no'] ?? '-',
            'field_60' => $addon['corporation']['subdistrict'] ?? '-',
            'field_61' => $addon['corporation']['district'] ?? '-',
            'field_62' => $addon['corporation']['province'] ?? '-',
            'field_63' => $addon['corporation']['tel'] ?? '-',
            'field_64' => $addon['corporation']['fax'] ?? '-',
            'field_65' => $addon['corporation']['name'] ?? '-',
            'field_66' => $addon['corporation']['corp_registered_no'] ?? '-',
            'field_67' => $addon['license_no1'] ?? '-',
            'field_68' => $addon['at1'] ?? '-',
            'field_69' => $addon['home_no1'] ?? '-',
            'field_70' => $addon['alley1'] ?? '-',
            'field_71' => $addon['road1'] ?? '-',
            'field_72' => $addon['village_no1'] ?? '-',
            'field_73' => $addon['subdistrict1'] ?? '-',
            'field_74' => $addon['district1'] ?? '-',
            'field_75' => $addon['province1'] ?? '-',
            'field_76' => $dayat1 ?? '-',
            'field_77' => $monthat1 ?? '-',
            'field_78' => $yearat1 ?? '-',
            'field_79' => $addon['name1'] ?? '-',
            'field_80' => $addon['option3'] ?? '-',
            'field_81' => $addon['no1'] ?? '-',
            'field_82' => $addon['name2'] ?? '-',
            'field_83' => $dayendat ?? '-',
            'field_84' => $monthendat ?? '-',
            'field_85' => $yearendat ?? '-',
            'field_86' => $addon['type2'] ?? '-',
            'field_87' => $addon['num'] ?? '-',
            'field_88' => $addon['use'] ?? '-',
            'field_89' => $addon['num1'] ?? '-',
            'field_90' => $addon['with'] ?? '-',
            'field_91' => $addon['to'] ?? '-',
            'field_92' => $addon['ExtraTime'] ?? '-',
            'field_93' => $addon['nameCon'] ?? '-',
            'field_94' => $addon['cardIdCon'] ?? '-',
            'field_95' => $addon['supervisor']['name'] ?? '-',
            'field_96' => $addon['supervisor']['card_id'] ?? '-',

            'field_00' => $trashRequest->id ?? '-',
            'field_option' => $addon["option"] ?? '-',
        ];

        // ✅ ดึงชื่อ field_name ของไฟล์ทั้งหมด
        $uploadedFiles = $trashRequest->files->pluck('field_name')->toArray();

        // ✅ เลือก view ตาม type
        $type = $trashRequest->type ?? 'trash_request'; // กันกรณีไม่มี type
        $viewPath = "pdf.$type.pdf";

        return Pdf::loadView($viewPath, compact('fields', 'day', 'month', 'year', 'uploadedFiles'))
            ->setPaper('A4', 'portrait')
            ->stream("คำร้องขอ$type.pdf");
    }


    public function historyRequest($type)
    {
        $userId = auth()->id();
        $trashRequests = \App\Models\TrashRequest::where('type', $type)
            ->where('creator_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // เพิ่มการตรวจสอบวันหมดอายุ
        foreach ($trashRequests as $request) {
            $addon = is_array($request->addon) ? $request->addon : json_decode($request->addon, true);

            if (!empty($addon['license_expire_at'])) {
                $expireDate = \Carbon\Carbon::parse($addon['license_expire_at']);
                $request->show_renew_button = now()->diffInDays($expireDate, false) <= 30; // เหลือน้อยกว่า 1 เดือน
            } else {
                $request->show_renew_button = false;
            }
        }

        return view('user.form_request.history-request', compact('trashRequests', 'type'));
    }
    
    public function userRenewLicense(Request $request, $id)
    {
        $trashRequest = \App\Models\TrashRequest::findOrFail($id);

        // Decode addon
        $addon = is_array($trashRequest->addon) ? $trashRequest->addon : json_decode($trashRequest->addon, true);

        // อัปเดตค่าใหม่
        $addon['remark'] = $request->remark ?? '';
        $addon['license_expire_at'] = $request->new_expire_date ?? $addon['license_expire_at'] ?? null;

        $trashRequest->addon = $addon;
        $trashRequest->status = 'ขอต่ออายุใบอนุญาต';
        $trashRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'ส่งคำขอต่ออายุเรียบร้อยแล้ว'
        ]);
    }


    public function showDetail($type, $id)
    {
        $trashRequest = TrashRequest::findOrFail($id);
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : null;
        // ส่ง $type ไปด้วยสำหรับ view
        return view('admin_request.public-health.detail.' . $type, compact('trashRequest', 'addon', 'type'));
    }

    public function showDetailEng($type, $id)
    {
        $trashRequest = TrashRequest::findOrFail($id);
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : null;
        // ส่ง $type ไปด้วยสำหรับ view
        return view('admin_request.engineering.detail.' . $type, compact('trashRequest', 'addon', 'type'));
    }

    public function showUserRequestDetail($type, $id)
    {
        $userId = auth()->id();
        $trashRequest = TrashRequest::where('id', $id)
            ->where('creator_id', $userId)
            ->where('type', $type)
            ->firstOrFail();
        
        $files = TrashRequestFile::where('trash_request_id', $trashRequest->id)->get();
        $trashRequest->files = $files;
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];
        return view('user.form_request.detail.' . $type, compact('trashRequest', 'addon'));
    }

    public function appointmentData($type)
    {
        // ดึงข้อมูลที่รอการนัดหมาย
        $trashRequests = TrashRequest::with('receiver:id,name', 'files')
            ->where('type', $type)
            ->whereIn('status', ['รอการนัดหมาย', 'รอยืนยันนัดหมาย'])
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = TrashRequestHistory::with('responder:id,name')
            ->get()
            ->groupBy('trash_request_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                });
            });

        return view('admin_request.public-health.appointment', compact('trashRequests', 'histories', 'type'));
    }

    public function appointmentDataEngineer($type)
    {
        // ดึงข้อมูลที่รอการนัดหมาย
        $trashRequests = TrashRequest::with('receiver:id,name', 'files')
            ->where('type', $type)
            ->whereIn('status', ['รอการนัดหมาย', 'รอยืนยันนัดหมาย'])
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = TrashRequestHistory::with('responder:id,name')
            ->get()
            ->groupBy('trash_request_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                });
            });

        return view('admin_request.engineering.appointment', compact('trashRequests', 'histories', 'type'));
    }

    public function appointmentDetail($type, $id)
    {
        $trashRequest = TrashRequest::findOrFail($id); // ดึงข้อมูลตาม id
        return view('admin_request.public-health.appointment.detail', compact('trashRequest'));
    }

    public function appointmentDetailEng($type, $id)
    {
        $trashRequest = TrashRequest::findOrFail($id); // ดึงข้อมูลตาม id
        return view('admin_request.engineering.appointment.detail', compact('trashRequest'));
    }
    

    public function appointmentStore(Request $request, $id)
    {
        try {
            $trashRequest = TrashRequest::findOrFail($id);

            $appointmentDate = $request->appointment_datetime;
            $convenientDate = $request->convenient_datetime ?? $trashRequest->convenient_date;

            // บันทึก appointment_date
            $trashRequest->appointment_date = $appointmentDate;

            // แปลง addon เป็น array ก่อนเพิ่มข้อมูล
            $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];
            $addon['appointment'] = [
                'title' => $request->title,
                'detail' => $request->detail,
            ];
            $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);

            $appointmentCarbon = Carbon::parse($appointmentDate)->format('Y-m-d H:i');
            $convenientCarbon = $convenientDate ? Carbon::parse($convenientDate)->format('Y-m-d H:i') : null;

            if ($convenientCarbon && $appointmentCarbon === $convenientCarbon) {
                $trashRequest->status = 'รอออกสำรวจ';
            } else {
                $trashRequest->status = 'รอยืนยันนัดหมาย';
            }

            $trashRequest->save();

            // -------------------------
            // ส่ง LINE แจ้งผู้สร้างคำขอ
            // -------------------------
            if ($trashRequest->creator && $trashRequest->creator->line_user_id) {
                $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
                $url = url("user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

                $lineMessage = "นัดหมายของคุณถูกอัปเดตเรียบร้อย\nประเภท: {$typeTitle}\nสถานะ: {$trashRequest->status}\nดูรายละเอียด: {$url}";

                $lineController = new LineMessagingController();
                $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function confirmAppointmentUser(Request $request, $id)
    {
        $trashRequest = TrashRequest::findOrFail($id);
        $convenientDate = $request->input('convenient_date');

        // บันทึกวันที่สะดวก
        $trashRequest->convenient_date = $convenientDate;

        // แปลงวันนัดเดิมให้อยู่ในรูปแบบ datetime-local
        $appointmentDate = Carbon::parse($trashRequest->appointment_date)->format('Y-m-d\TH:i');

        // ตรวจสอบว่าผู้ใช้สะดวกในวันนัดเดิมหรือไม่
        if ($convenientDate === $appointmentDate) {
            $trashRequest->status = 'รอออกสำรวจ'; // ใช้วันนัดเดิม
        } else {
            $trashRequest->status = 'รอการนัดหมาย'; // เลือกวันใหม่
        }

        $trashRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทสถานะเรียบร้อย'
        ]);
    }


    public function explore($type)
    {
        // ดึงคำร้องเฉพาะที่สถานะ 'รอออกสำรวจ'
        $trashRequests = TrashRequest::with('receiver:id,name', 'files')
            ->where('type', $type)
            ->where('status', 'รอออกสำรวจ')
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = TrashRequestHistory::with('responder:id,name')
            ->get()
            ->groupBy('trash_request_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                });
            });

        // ส่งไปยัง view เดิมหรือสร้าง view ใหม่
        return view('admin_request.public-health.explore', compact('trashRequests', 'histories', 'type'));
    }

    public function exploreEng($type)
    {
        // ดึงคำร้องเฉพาะที่สถานะ 'รอออกสำรวจ'
        $trashRequests = TrashRequest::with('receiver:id,name', 'files')
            ->where('type', $type)
            ->where('status', 'รอออกสำรวจ')
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = TrashRequestHistory::with('responder:id,name')
            ->get()
            ->groupBy('trash_request_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                });
            });

        // ส่งไปยัง view เดิมหรือสร้าง view ใหม่
        return view('admin_request.engineering.explore', compact('trashRequests', 'histories', 'type'));
    }
    
    public function inspectionStore(Request $request, $id)
    {
        $request->validate([
            'inspection_result' => 'required|string',
            'inspection_date' => 'required|date',
            'inspection_note' => 'nullable|string',
        ]);

        $trashRequest = TrashRequest::findOrFail($id);

        // ดึง addon เดิมหรือสร้าง array ใหม่
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];
        $addon['inspection'] = [
            'result' => $request->inspection_result,
            'note' => $request->inspection_note,
            'date' => $request->inspection_date,
            'inspector_id' => auth()->id()
        ];

        if ($request->inspection_result === 'ผ่าน') {
            $trashRequest->status = 'รอชำระเงิน';
        } elseif ($request->inspection_result === 'ไม่ผ่าน') {
            $trashRequest->status = 'รอการนัดหมาย'; // ให้กลับไปนัดสำรวจใหม่
        }

        $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);
        $trashRequest->save();

        // -------------------------
        // ส่ง LINE แจ้งผู้สร้างคำขอ
        // -------------------------
        if ($trashRequest->creator && $trashRequest->creator->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
            $url = url("user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $lineMessage = "ผลการตรวจสอบคำร้องของคุณถูกบันทึกเรียบร้อย\nประเภท: {$typeTitle}\nผล: {$request->inspection_result}\nสถานะ: {$trashRequest->status}\nดูรายละเอียด: {$url}";

            $lineController = new LineMessagingController();
            $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
        }


        return response()->json([
            'success' => true,
            'message' => 'บันทึกผลสำรวจเรียบร้อย'
        ]);
    }

    public function uploadSlipUser(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $trashRequest = TrashRequest::where('id', $id)
            ->where('creator_id', auth()->id())
            ->firstOrFail();

        $path = $request->file('slip')->store('payment_slips', 'public');

        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];
        $addon['payment'] = [
            'amount' => $request->amount,
            'slip_path' => $path,
            'submitted_at' => now(),
            'status' => 'รอตรวจสอบ'
        ];

        $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);
        $trashRequest->status = 'รอตรวจสอบการชำระเงิน';
        $trashRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'ส่งหลักฐานเรียบร้อย'
        ]);
    }

    public function confirmPaymentRequest($type)
    {
        $trashRequests = TrashRequest::where('type', $type)
            ->whereIn('status', ['รอตรวจสอบการชำระเงิน','รอชำระเงิน'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_request.public-health.confirmpayment', compact('trashRequests', 'type'));
    }

    public function confirmPaymentRequestEng($type)
    {
        $trashRequests = TrashRequest::where('type', $type)
            ->whereIn('status', ['รอตรวจสอบการชำระเงิน','รอชำระเงิน'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_request.engineering.confirmpayment', compact('trashRequests', 'type'));
    }

    public function confirmPaymentRequestStore(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|string|in:approve,reject',
            'note' => 'nullable|string|max:500',
        ]);

        $trashRequest = TrashRequest::findOrFail($id);
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];

        if (!isset($addon['payment'])) {
            return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลการชำระเงิน']);
        }

        if ($request->action === 'approve') {
            $addon['payment']['status'] = 'ชำระเงินเรียบร้อย';
            $trashRequest->status = 'รอออกใบอนุญาต';
        } else {
            $addon['payment']['status'] = 'ไม่อนุมัติ';
            $addon['payment']['admin_note'] = $request->note;
            $trashRequest->status = 'รอตรวจสอบการชำระเงิน';
        }

        $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);
        $trashRequest->save();

        // -------------------------
        // ส่ง LINE แจ้งผู้สร้างคำขอ
        // -------------------------
        if ($trashRequest->creator && $trashRequest->creator->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
            $url = url("user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $statusText = $request->action === 'approve' ? 'ชำระเงินเรียบร้อย' : 'ไม่อนุมัติ';

            $lineMessage = "สถานะการชำระเงินคำร้องของคุณถูกอัปเดต\nประเภท: {$typeTitle}\nสถานะ: {$trashRequest->status}\nผล: {$statusText}\nดูรายละเอียด: {$url}";

            $lineController = new LineMessagingController();
            $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
        }

        return response()->json(['success' => true, 'message' => 'อัพเดทสถานะเรียบร้อย']);
    }


    public function issueLicense($type)
    {
        // ดึงคำร้องที่ status เป็น 'รอออกใบอนุญาต' หรือ 'เสร็จสิ้น'
        $trashRequests = TrashRequest::with('receiver:id,name', 'histories')
            ->where('type', $type)
            ->whereIn('status', ['รอออกใบอนุญาต', 'ออกใบอนุญาตเสร็จสิ้น'])
            ->orderBy('created_at', 'desc')
            ->get();

        // เพิ่ม field วันที่อัปเดตล่าสุดจากประวัติ
        $trashRequests->transform(function ($request) {
            $latestHistory = $request->histories->sortByDesc('created_at')->first();
            $request->latest_update = $latestHistory ? $latestHistory->created_at->format('d/m/Y H:i') : '-';
            return $request;
        });

        return view('admin_request.public-health.Issue-a-license', compact('trashRequests', 'type'));
    }

    public function issueLicenseEng($type)
    {
        // ดึงคำร้องที่ status เป็น 'รอออกใบอนุญาต' หรือ 'เสร็จสิ้น'
        $trashRequests = TrashRequest::with('receiver:id,name', 'histories')
            ->where('type', $type)
            ->whereIn('status', ['รอออกใบอนุญาต', 'ออกใบอนุญาตเสร็จสิ้น'])
            ->orderBy('created_at', 'desc')
            ->get();

        // เพิ่ม field วันที่อัปเดตล่าสุดจากประวัติ
        $trashRequests->transform(function ($request) {
            $latestHistory = $request->histories->sortByDesc('created_at')->first();
            $request->latest_update = $latestHistory ? $latestHistory->created_at->format('d/m/Y H:i') : '-';
            return $request;
        });

        return view('admin_request.engineering.Issue-a-license', compact('trashRequests', 'type'));
    }


    public function uploadLicense(Request $request, $id)
    {
        $request->validate([
            'license_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $trashRequest = TrashRequest::findOrFail($id);

        $file = $request->file('license_file');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('licenses', $filename, 'public');

        // บันทึกไฟล์ลง addon
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];
        $addon['license'] = [
            'file_path' => $path,
            'uploaded_at' => now(),
            'uploaded_by' => auth()->id(),
        ];

        // อัปเดตสถานะคำร้อง
        $trashRequest->status = 'เสร็จสิ้น';
        $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);
        $trashRequest->save();

        // เพิ่มประวัติการอัปเดตสถานะ
        TrashRequestHistory::create([
            'trash_request_id' => $trashRequest->id,
            'user_id' => auth()->id(),
            'message' => 'ออกใบอนุญาตและอัปโหลดไฟล์เรียบร้อย',
            'status_after' => $trashRequest->status
        ]);

        return response()->json(['success' => true, 'message' => 'อัปโหลดใบอนุญาตเรียบร้อย']);
    }

    public function showPdfReceiptBill($billId)
{
    $bill = Bill::with('trashLocation.trashRequest.files')->findOrFail($billId);

    $trashRequest = $bill->trashLocation?->trashRequest;
    if (!$trashRequest) {
        abort(404, 'ไม่พบคำร้อง');
    }

    $trashLocation = $bill->trashLocation;

    // วัน เดือน ปี ภาษาไทย
    $date = \Carbon\Carbon::parse($trashRequest->created_at ?? now());
    $day = (int) $date->format('d');
    $thaiMonths = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
        5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
        9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    ];
    $month = $thaiMonths[(int)$date->format('m')];
    $year = $date->format('Y') + 543;

    $amount = number_format($bill->amount ?? 0, 2, '.', '');
    [$baht, $satang] = explode('.', $amount);

    $fields = [
        'field_1'  => $trashRequest->fullname ?? '-',
        'field_2'  => $trashRequest->prefix ?? '-',
        'field_3'  => $month ?? '-',
        'field_4'  => $baht ?? '-',
        'field_15' => $satang ?? '-',
        'field_5'  => $trashRequest->house_no ?? '-',
        'field_6'  => $trashRequest->village_no ?? '-',
        'field_7'  => $trashLocation?->subdistrict ?? '-',
        'field_8'  => $trashLocation?->district ?? '-',
        'field_9'  => $trashLocation?->province ?? '-',
        'field_12' => $trashRequest->place_type ?? '-',
        'field_13' => $trashRequest->alley ?? '-',
        'field_14' => $trashRequest->road ?? '-',
    ];

    $uploadedFiles = $trashRequest->files->pluck('field_name')->toArray();

    return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.receipt_bill.pdf', compact(
        'fields','day','month','year','uploadedFiles'
    ))
    ->setPaper('A4', 'portrait')
    ->stream('ใบเสร็จค่ามูลฝอย.pdf');
}


    public function showLicensePdf($type, $id)
    {
        // ดึง TrashRequest พร้อมไฟล์
        $trashRequest = TrashRequest::with('files')->findOrFail($id);

        // วัน เดือน ปี ภาษาไทย
        $date = \Carbon\Carbon::parse($trashRequest->created_at ?? now());
        $day = $date->format('d');
        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $month = $thaiMonths[(int)$date->format('m')];
        $year = $date->format('Y') + 543;
        $addon = json_decode($trashRequest->addon, true);
        if (!empty($addon['payment']['submitted_at'])) {
            $submittedAt = Carbon::parse($addon['payment']['submitted_at']);
            $dayPayment = (int) $submittedAt->format('d'); // เอาแค่วัน
            $monthPayment = $thaiMonths[(int)$submittedAt->format('m')];
            $yearPayment = $submittedAt->format('Y') + 543;
        } else {
            $dayPayment = '-';
            $monthPayment = '-';
            $yearPayment = '-';
        } 
        if (!empty($addon['license_issued_at'])) {
            $licenseAt = Carbon::parse($addon['license_issued_at']);
            $daylicenseAt = (int) $licenseAt->format('d'); // เอาแค่วัน
            $monthlicenseAt = $thaiMonths[(int)$licenseAt->format('m')];
            $yearlicenseAt = $licenseAt->format('Y') + 543;

            $expireAt = Carbon::parse($addon['license_expire_at']);
            $dayexpireAt = (int) $expireAt->format('d'); // เอาแค่วัน
            $monthexpireAt = $thaiMonths[(int)$expireAt->format('m')];
            $yearexpireAt = $expireAt->format('Y') + 543;
        } else {
            $daylicenseAt = '';
            $monthlicenseAt = '';
            $yearlicenseAt = '';

            $dayexpireAt = '';
            $monthexpireAt = '';
            $yearexpireAt = '';
        }  
        if (!empty($addon['license_issued_by'])) {
            $user = User::find($addon['license_issued_by']);
            if ($user) {
                $licenseIssuedBy = $user->name; // หรือฟิลด์อื่น ๆ เช่น fullname
            }
        }

        if (!empty($addon['at1'])) {
            $at1 = Carbon::parse($addon['at1']);
            $dayat1 = (int) $at1->format('d'); // เอาแค่วัน
            $monthat1 = $thaiMonths[(int)$at1->format('m')];
            $yearat1 = $at1->format('Y') + 543;

        } else {
            $dayat1 = '';
            $monthat1 = '';
            $yearat1 = '';
        }  

        if (!empty($addon['endat'])) {
            $endat = Carbon::parse($addon['endat']);
            $dayendat = (int) $endat->format('d'); // เอาแค่วัน
            $monthendat = $thaiMonths[(int)$endat->format('m')];
            $yearendat = $endat->format('Y') + 543;

        } else {
            $dayendat = '';
            $monthendat = '';
            $yearendat = '';
        }  
        
        if (!empty($addon['license_issued_by'])) {
            $user = User::find($addon['license_issued_by']);
            if ($user) {
                $licenseIssuedBy = $user->name; // หรือฟิลด์อื่น ๆ เช่น fullname
            }
        }
        
        // Mapping fields สำหรับ PDF
        $fields = [
            'field_1' => $trashRequest->fullname ?? '-',
            'field_2' => $trashRequest->prefix ?? '-',
            'field_3' => $trashRequest->age ?? '-',
            'field_4' => $trashRequest->nationality ?? '-',
            'field_5' => $trashRequest->id_card ?? '-',
            'field_6' => $trashRequest->alley ?? '-',
            'field_7' => $trashRequest->road ?? '-',
            'field_8' => $trashRequest->house_no ?? '-',
            'field_9' => $trashRequest->village_no ?? '-',
            'field_10' => $trashRequest?->subdistrict ?? '-',
            'field_11' => $trashRequest?->district ?? '-',
            'field_12' => $trashRequest?->province ?? '-',
            'field_13' => $trashRequest?->tel ?? '-',
            'field_14' => $trashRequest?->fax ?? '-',
            'field_15' => $addon['personal'] ?? '-',
            'field_16' => $addon['payment']['amount'] ?? '-',
            'field_17' => $dayPayment ?? '-',
            'field_18' => $monthPayment ?? '-',
            'field_19' => $yearPayment ?? '-',
            'field_20' => $addon['individual']['type'] ?? '-',
            'field_21' => $addon['individual']['room_count'] ?? '-',
            'field_22' => $addon['individual']['home_rent'] ?? '-',
            'field_23' => $addon['individual']['home_rent'] ?? '-',
            'field_24' => $addon['corporation']['type'] ?? '-',
            'field_25' => $addon['corporation']['worker_count'] ?? '-',
            'field_26' => $addon['corporation']['machine_power'] ?? '-',
            'field_27' => $daylicenseAt ?? '',
            'field_28' => $monthlicenseAt ?? '',
            'field_29' => $yearlicenseAt ?? '',
            'field_30' => $dayexpireAt ?? '',
            'field_31' => $monthexpireAt ?? '',
            'field_32' => $yearexpireAt ?? '',
            'field_33' => $licenseIssuedBy ?? '',
            'field_34' => $addon["name"] ?? '-',
            'field_35'=> $addon["area"] ?? '-',
            'field_36'=> $addon["house_no"] ?? '-',
            'field_37'=> $addon["alley"] ?? '-',
            'field_38'=> $addon["road"] ?? '-',
            'field_39'=> $addon["village_no"] ?? '-',
            'field_40'=> $addon["tel"] ?? '-',
            'field_41'=> $addon["year"] ?? '',
            'field_42'=> $addon["subdistrict"] ?? null,
            'field_43'=> $addon["district"] ?? null,
            'field_44'=> $addon["province"] ?? null,
            'field_45'=> $addon["at"] ?? '-',
            'field_46'=> $addon["license_no1"] ?? '',
            'field_47'=> $addon["at1"] ?? '-',
            'field_48'=> $addon["home_no1"] ?? '-',
            'field_49'=> $addon["alley1"] ?? '-',
            'field_50'=> $addon["road1"] ?? '-',
            'field_51'=> $addon["village_no1"] ?? '-',
            'field_52' => $addon['individual']['card_id'] ?? '-',
            'field_53' => $addon['postcode'] ?? '-',
            'field_54' => $addon['corporation']['postcode'] ?? '-',
            'field_55' => $addon['corporation']['corp_registered_at'] ?? '-',
            '/* The above code appears to be a comment block in PHP. It starts with /* and ends with
            */, which is the syntax for multi-line comments in PHP. Inside the comment block, there
            is a line "field_56" followed by " */
            field_56' => $addon['corporation']['corp_home_no'] ?? '-',
            'field_57' => $addon['corporation']['alley'] ?? '-',
            'field_58' => $addon['corporation']['road'] ?? '-',
            'field_59' => $addon['corporation']['corp_village_no'] ?? '-',
            'field_60' => $addon['corporation']['subdistrict'] ?? '-',
            'field_61' => $addon['corporation']['district'] ?? '-',
            'field_62' => $addon['corporation']['province'] ?? '-',
            'field_63' => $addon['corporation']['tel'] ?? '-',
            'field_64' => $addon['corporation']['fax'] ?? '-',
            'field_65' => $addon['corporation']['name'] ?? '-',
            'field_66' => $addon['corporation']['corp_registered_no'] ?? '-',
            'field_67' => $addon['license_no1'] ?? '-',
            'field_68' => $addon['at1'] ?? '-',
            'field_69' => $addon['home_no1'] ?? '-',
            'field_70' => $addon['alley1'] ?? '-',
            'field_71' => $addon['road1'] ?? '-',
            'field_72' => $addon['village_no1'] ?? '-',
            'field_73' => $addon['subdistrict1'] ?? '-',
            'field_74' => $addon['district1'] ?? '-',
            'field_75' => $addon['province1'] ?? '-',
            'field_76' => $dayat1 ?? '-',
            'field_77' => $monthat1 ?? '-',
            'field_78' => $yearat1 ?? '-',
            'field_79' => $addon['name1'] ?? '-',
            'field_80' => $addon['option3'] ?? '-',
            'field_81' => $addon['no1'] ?? '-',
            'field_82' => $addon['name2'] ?? '-',
            'field_83' => $dayendat ?? '-',
            'field_84' => $monthendat ?? '-',
            'field_85' => $yearendat ?? '-',
            'field_86' => $addon['type2'] ?? '-',
            'field_87' => $addon['num'] ?? '-',
            'field_88' => $addon['use'] ?? '-',
            'field_89' => $addon['num1'] ?? '-',
            'field_90' => $addon['with'] ?? '-',
            'field_91' => $addon['to'] ?? '-',
            'field_92' => $addon['ExtraTime'] ?? '-',
            'field_93' => $addon['nameCon'] ?? '-',
            'field_94' => $addon['cardIdCon'] ?? '-',
            'field_95' => $addon['supervisor']['name'] ?? '-',
            'field_96' => $addon['supervisor']['card_id'] ?? '-',
            'field_97' => $addon['fax'] ?? '-',

            'field_00' => $trashRequest->id ?? '-',
            'field_option' => $addon["option"] ?? '-',
        ];
        
        // ไฟล์ที่อัพโหลด
        $uploadedFiles = $trashRequest->files->pluck('field_name')->toArray();

        // สร้างชื่อ view dynamic ตาม type
        $view = "pdf.license.{$type}-pdf";

        // ตรวจสอบว่า view มีจริงไหม
        if (!view()->exists($view)) {
            abort(404, "ไม่พบ template สำหรับประเภท: {$type}");
        }

        // สร้าง PDF
        return Pdf::loadView($view, compact('fields', 'day', 'month', 'year', 'uploadedFiles'))
            ->setPaper('A4', 'portrait')
            ->stream("ใบอนุญาต_{$type}_{$trashRequest->fullname}.pdf");
    }

    public function saveLicense($id)
    {
        $trashRequest = TrashRequest::with('creator')->findOrFail($id);

        $now = Carbon::now();

        // ตรวจสอบ addon ก่อนใช้งาน
        $addon = is_array($trashRequest->addon) ? $trashRequest->addon : ($trashRequest->addon ? json_decode($trashRequest->addon, true) : []);
        if (!is_array($addon)) {
            $addon = [];
        }

        // เพิ่มข้อมูลใบอนุญาต
        $addon['license_issued_at'] = $now->toDateString(); // วันที่ออกใบอนุญาต
        $addon['license_expire_at'] = $now->copy()->addYear()->toDateString(); // วันหมดอายุ +1 ปี
        $addon['license_issued_by'] = Auth::id(); // รหัสผู้บันทึก
        // $addon['license_type'] = Auth::id();

        $trashRequest->addon = $addon;

        // อัปเดตสถานะ
        $trashRequest->status = 'ออกใบอนุญาตเสร็จสิ้น';

        $trashRequest->save();

        
        // -------------------------
        // ส่ง LINE แจ้งผู้สร้างคำขอ
        // -------------------------
        if ($trashRequest->creator && $trashRequest->creator->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
            $lineMessage = "ใบอนุญาตของคุณถูกออกเรียบร้อยแล้ว ✅\nประเภท: {$typeTitle}\nสถานะ: {$trashRequest->status}\nดูรายละเอียด: " . url("/user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $lineController = new LineMessagingController();
            $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
        }

        return response()->json([
            'success' => true,
            'message' => 'บันทึกใบอนุญาตเรียบร้อยแล้ว'
        ]);
    }

    public function renewLicense($type)
    {
        $trashRequests = \App\Models\TrashRequest::with(['receiver:id,name', 'histories'])
            ->where('type', $type)
            ->whereIn('status', ['ออกใบอนุญาตเสร็จสิ้น','รอต่ออายุใบอนุญาต', 'ต่ออายุเสร็จสิ้น'])
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(addon, '$.license_expire_at')) < ?", [now()->addMonth()->toDateString()])
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($trashRequests);

        $trashRequests->transform(function ($request) {
            $latestHistory = $request->histories->sortByDesc('created_at')->first();
            $request->latest_update = $latestHistory ? $latestHistory->created_at->format('d/m/Y H:i') : '-';

            // แปลงวันที่จาก addon JSON
            $addon = json_decode($request->addon, true);
            $request->license_expire_at = isset($addon['license_expire_at'])
                ? \Carbon\Carbon::parse($addon['license_expire_at'])->format('d/m/Y')
                : '-';

            return $request;
        });

        return view('admin_request.public-health.renew-license', compact('trashRequests', 'type'));
    }

    public function saveRenewLicense($id)
    {
    $trashRequest = \App\Models\TrashRequest::with('creator')->findOrFail($id); 
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : [];

        $addon['renew'] = [
            'renewed_at' => now(),
            'admin_id' => auth()->id(),
        ];

        $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);
        $trashRequest->status = 'ต่ออายุเสร็จสิ้น';
        $trashRequest->save();

        \App\Models\TrashRequestHistory::create([
            'trash_request_id' => $trashRequest->id,
            'user_id' => auth()->id(),
            'message' => 'ต่ออายุใบอนุญาตเรียบร้อย',
            'status_after' => $trashRequest->status
        ]);

         // -------------------------
        // ส่ง LINE แจ้งผู้สร้างคำขอ
        // -------------------------
        if ($trashRequest->creator && $trashRequest->creator->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);
            $lineMessage = "ใบอนุญาตของคุณถูกต่ออายุเรียบร้อย ✅\nประเภท: {$typeTitle}\nสถานะ: {$trashRequest->status}\nดูรายละเอียด: " . url("/user/request/history_request/{$trashRequest->type}/{$trashRequest->id}");

            $lineController = new LineMessagingController();
            $lineController->pushMessage($trashRequest->creator->line_user_id, $lineMessage);
        }

        return response()->json(['success' => true, 'message' => 'บันทึกการต่ออายุเรียบร้อย']);
    }
}
