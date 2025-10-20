<?php

namespace App\Http\Controllers;

use App\Models\TrashRequest;
use App\Models\TrashRequestHistory;
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
            'field_5' => 'required|integer',
            'field_6' => 'required|string',
            'field_3' => 'required|digits:10',
            'field_7' => 'required|string',
            'field_8' => 'required|string',
            'field_9' => 'required|string',
            'field_10' => 'required|string',
            'field_11' => 'required|string',
            'field_15' => 'required|string',
            'field_14' => 'required|string',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $requestData = [
            'prefix' => $validated['field_1'],
            'fullname' => $validated['field_2'],
            'age' => $validated['field_5'],
            'nationality' => $validated['field_6'],
            'tel' => $validated['field_3'],
            'fax' => $request->field_4,
            'house_no' => $validated['field_7'],
            'village_no' => $validated['field_8'],
            'alley' => $validated['field_14'],
            'road' => $validated['field_15'],
            'subdistrict' => $validated['field_9'],
            'district' => $validated['field_10'],
            'province' => $validated['field_11'],
            'place_type' => $request->optione,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'type' => 'trash-request',
            'status' => 'pending',
            'receiver_id' => null,
            'received_at' => now(),
        ];

        // ✅ จัดการไฟล์แนบ
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $paths[] = $file->storeAs('trash_pictures', $filename, 'public');
            }
            $requestData['picture_path'] = implode(',', $paths); // เก็บเป็น string คั่นด้วย comma
        }


        TrashRequest::create($requestData);

        return redirect()->back()->with('success', 'บันทึกคำขอเรียบร้อยแล้ว!');
    }

    public function showData()
    {
        // ดึงข้อมูล trashRequests พร้อมกับชื่อผู้รับฟอร์มจาก user
        $trashRequests = TrashRequest::with('receiver:id,name')
            ->where('type', 'trash-request')
            ->orderBy('created_at', 'desc')
            ->get();

        // ดึง histories พร้อมกับชื่อผู้ตอบกลับจาก user
        $histories = TrashRequestHistory::with('responder:id,name')->get();

        return view('admin_trash.showdata', compact('trashRequests', 'histories'));
    }


    public function reply(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:trash_requests,id',
            'message' => 'required|string',
        ]);

        // สร้างประวัติ reply
        TrashRequestHistory::create([
            'trash_request_id' => $request->request_id,
            'user_id' => auth()->id(), // ใช้ผู้ใช้งานปัจจุบัน
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    public function accept(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:trash_requests,id',
        ]);

        $trashRequest = TrashRequest::findOrFail($request->request_id);
        $user = $request->user_id; // ผู้ที่กดรับ

        $trashRequest->status = 'done';
        $trashRequest->receiver_id = $user;
        $trashRequest->received_at = now();
        $trashRequest->save();

        return response()->json(['success' => true]);
    }
    
    public function showPdf($id)
    {
        $trashRequest = TrashRequest::findOrFail($id);

        // แยกวัน เดือน ปี ถ้าไม่มีข้อมูลให้เป็น '-'
        $createdAt = $trashRequest->created_at ?? now(); // กรณีว่างใช้ now()
        $date = Carbon::parse($createdAt);

        $day = $date->format('d');          // วัน
        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $month = $thaiMonths[(int)$date->format('m')];       
        $year = $date->format('Y') + 543;  

        // เตรียม field ทั้งหมด ถ้าไม่มีค่าให้เป็น '-'
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



}
