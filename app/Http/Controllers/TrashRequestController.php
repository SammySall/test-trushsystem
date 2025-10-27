<?php

namespace App\Http\Controllers;

use App\Models\TrashRequest;
use App\Models\TrashRequestHistory;
use App\Models\TrashRequestFile;
use App\Models\TrashLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class TrashRequestController extends Controller
{
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

        // เก็บข้อมูลหลัก TrashRequest
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

        // สร้าง TrashRequest
        $trashRequest = TrashRequest::create($requestData);

        // เก็บไฟล์แยกใน trash_request_files
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

        return redirect()->back()->with('success', 'บันทึกคำขอเรียบร้อยแล้ว!');
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
            $location->save();

            // ✅ บันทึก id ของ trash_location กลับไปที่ trash_request ในช่อง addon
            $trashRequest->addon = $location->id;
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

        return response()->json(['success' => true]);
    }

    
    public function showPdfTrash($id)
    {
        $trashRequest = TrashRequest::with('files')->findOrFail($id);

        $date = Carbon::parse($trashRequest->created_at ?? now());
        $day = $date->format('d');
        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $month = $thaiMonths[(int)$date->format('m')];
        $year = $date->format('Y') + 543;

        $fields = [
            'field_1' => $trashRequest->fullname ?? '-',
            'field_2' => $trashRequest->prefix ?? '-',
            'field_3' => $trashRequest->tel ?? '-',
            'field_4' => $trashRequest->place_type ?? '-',
            'field_5' => $trashRequest->age ?? '-',
            'field_6' => $trashRequest->nationality ?? '-',
            'field_7' => $trashRequest->house_no ?? '-',
            'field_8' => $trashRequest->village_no ?? '-',
            'field_9' => $trashRequest->subdistrict ?? '-',
            'field_10' => $trashRequest->district ?? '-',
            'field_11' => $trashRequest->province ?? '-',
            'field_12' => $trashRequest->place_type ?? '-',
            'field_13' => $trashRequest->alley ?? '-',
            'field_14' => $trashRequest->road ?? '-',
            'field_15' => $trashRequest->fax ?? '-',
        ];

        // ✅ ดึงชื่อ field_name ของไฟล์ทั้งหมด
        $uploadedFiles = $trashRequest->files->pluck('field_name')->toArray();

        return Pdf::loadView('pdf.trash_request.pdf', compact('fields', 'day', 'month', 'year', 'uploadedFiles'))
            ->setPaper('A4', 'portrait')
            ->stream('คำร้องขอลงถังขยะ.pdf');
    }


    public function historyRequest($type)
    {
        $userId = auth()->id();
        $trashRequests = TrashRequest::where('type', $type)
            ->where('creator_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.form_request.history-request', compact('trashRequests', 'type'));
    }



    public function showDetail($type, $id)
    {
        $trashRequest = TrashRequest::findOrFail($id);
        $addon = $trashRequest->addon ? json_decode($trashRequest->addon, true) : null;
        // ส่ง $type ไปด้วยสำหรับ view
        return view('admin_request.public-health.detail.' . $type, compact('trashRequest', 'addon', 'type'));
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

        $trashRequest->convenient_date = $convenientDate;

        $appointmentDate = Carbon::parse($trashRequest->appointment_date)->format('Y-m-d\TH:i');

        if ($convenientDate === $appointmentDate) {
            $trashRequest->status = 'รอออกสำรวจ';
        } else {
            $trashRequest->status = 'รอการนัดหมาย';
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
            ->where('status', 'รอตรวจสอบการชำระเงิน')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_request.public-health.confirmpayment', compact('trashRequests', 'type'));
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

        return view('admin_request.public-health.issue-a-license', compact('trashRequests', 'type'));
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

    public function showPdfReceiptBill($id)
    {
        // ดึง TrashRequest พร้อมไฟล์
        $trashRequest = TrashRequest::with('files')
            ->where('addon', $id) 
            ->firstOrFail();

        // ดึง TrashLocation ตาม addon ของ TrashRequest
        $trashLocation = TrashLocation::where('id', $id)->first();
        // ดึงใบเสร็จล่าสุดของ TrashLocation
        $bill = $trashLocation?->bills()->latest()->first();

        // วัน เดือน ปี ภาษาไทย
        $date = Carbon::parse($trashRequest->created_at ?? now());
        $day = $date->format('d');
        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $month = $thaiMonths[(int)$date->format('m')];
        $year = $date->format('Y') + 543;

        $amount = number_format($bill?->amount ?? 0, 2, '.', ''); // ให้เป็นรูปแบบ "123.45"
        [$baht, $satang] = explode('.', $amount); // แยกตรงจุดทศนิยม


        // Mapping fields สำหรับ PDF
        $fields = [
            'field_1'  => $trashRequest->fullname ?? '-',
            'field_2'  => $trashRequest->prefix ?? '-',
            'field_3'  => $month ?? '-',
            'field_4'  => $baht ?? '-',
            'field_15'  => $satang ?? '-',
            'field_5'  => $trashRequest->house_no ?? '-',
            'field_6'  => $trashRequest->village_no ?? '-',
            'field_7'  => $trashLocation?->subdistrict ?? '-',
            'field_8'  => $trashLocation?->district ?? '-',
            'field_9'  => $trashLocation?->province ?? '-',
            'field_12' => $trashRequest->place_type ?? '-',
            'field_13' => $trashRequest->alley ?? '-',
            'field_14' => $trashRequest->road ?? '-',
        ];

        // ไฟล์ที่อัพโหลด
        $uploadedFiles = $trashRequest->files->pluck('field_name')->toArray();

        // สร้าง PDF
        return Pdf::loadView('pdf.receipt_bill.pdf', compact('fields', 'day', 'month', 'year', 'uploadedFiles'))
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
            'field_15' => '00',
            'field_20' => $trashRequest->id,
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
        return \Barryvdh\DomPDF\Facade\Pdf::loadView($view, compact('fields', 'day', 'month', 'year', 'uploadedFiles'))
            ->setPaper('A4', 'portrait')
            ->stream("ใบอนุญาต_{$type}_{$trashRequest->fullname}.pdf");
    }

    public function saveLicense($id)
    {
        $trashRequest = TrashRequest::findOrFail($id);

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

        $trashRequest->addon = $addon;

        // อัปเดตสถานะ
        $trashRequest->status = 'ออกใบอนุญาตเสร็จสิ้น';

        $trashRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'บันทึกใบอนุญาตเรียบร้อยแล้ว'
        ]);
    }


}
