<?php

namespace App\Http\Controllers;

use App\Models\TrashRequest;
use App\Models\TrashRequestHistory;
use App\Models\TrashRequestFile;
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



    public function showData()
    {
        $trashRequests = TrashRequest::with(['receiver:id,name', 'files'])
            ->where('type', 'trash-request')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $histories = TrashRequestHistory::with('responder:id,name')->get();

        // รวมข้อมูลประวัติและรูปภาพ
        $trashRequests->getCollection()->transform(function ($request) use ($histories) {
            $requestHistories = $histories->where('trash_request_id', $request->id)
                ->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                })->values();

            $request->histories = $requestHistories;
            $request->picture_path = $request->files->pluck('file_path')->toArray();

            return $request;
        });

        return view('admin_trash.showdata', compact('trashRequests'));
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
            $trashRequest->status = 'เสร็จสิ้น';
            $trashRequest->receiver_id = $user;
            $trashRequest->received_at = now();
            $trashRequest->save();

            $location = new \App\Models\TrashLocation();
            $location->name = $trashRequest->fullname;
            $location->address = $trashRequest->house_no . ' ' . $trashRequest->subdistrict . ' ' . $trashRequest->district . ' ' . $trashRequest->province;
            $location->status = 'รออนุมัติเรียกชำระเงิน';
            $location->tel = $trashRequest->tel ?? '0634461165';
            $location->save();
        } else {
            $trashRequest->status = 'รอการนัดหมาย';
            $trashRequest->receiver_id = $user;
            $trashRequest->received_at = now();
            $trashRequest->save();
        }

        return response()->json(['success' => true]);
    }
    
    public function showPdf($id)
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
        ];

        return Pdf::loadView('pdf.trash_request.pdf', compact('fields','day','month','year'))
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
            ->whereIn('status', ['รอออกใบอนุญาต', 'เสร็จสิ้น'])
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


}
