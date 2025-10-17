<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrashLocation;
use App\Models\Bill;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TrashLocationController extends Controller
{
    /**
     * แสดงรายการตำแหน่งติดตั้งถังขยะ พร้อมข้อมูลบิล
     */
    public function index()
    {
        // Eager load bills เพื่อลดจำนวน query
        $locations = TrashLocation::with('bills')->get();

        return view('admin.trash_can_installation.can-install', compact('locations'));
    }

    /**
     * แสดงรายละเอียดการติดตั้งถังขยะ พร้อมรายการบิล
     */
    public function showCanInstallDetail(int $id)
    {
        $location = TrashLocation::with('bills')->findOrFail($id);

        return view('admin.trash_can_installation.can-install-detail', compact('location'));
    }

    /**
     * แสดงรายละเอียดผู้ติดตั้งถังขยะ
     */
    public function showInstallerDetail(int $id)
    {
        $location = TrashLocation::with('bills')->findOrFail($id);

        return view('admin.trash_installer.trash-installer-detail', compact('location'));
    }

    /**
     * ยืนยันการชำระเงิน/สถานะการติดตั้ง
     */
    public function confirmPayment(Request $request, int $id)
    {
        $location = TrashLocation::findOrFail($id);

        try {
            $location->status = 'เสร็จสิ้น'; // ปรับให้ตรงกับ Blade
            $location->save();

            return response()->json([
                'success' => true,
                'status_text' => $location->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * แสดงเฉพาะตำแหน่งติดตั้งที่เสร็จสิ้น พร้อมบิล
     */
    public function installerTrash()
    {
        $locations = TrashLocation::with('bills')
            ->where('status', 'เสร็จสิ้น')
            ->get();

        return view('admin.trash_installer.trash-installer', compact('locations'));
    }

    public function nonPaymentList(Request $request)
    {
        // ดึงพารามิเตอร์เดือนและปี ถ้ามี
        $month = $request->input('month_filter');
        $year = $request->input('year_filter');

        $locations = TrashLocation::with(['bills' => function($query) use ($month, $year) {
            $query->where('status', 'ยังไม่ชำระ');

            // ถ้าเลือกเดือน
            if ($month) {
                $query->whereMonth('due_date', $month);
            }

            // ถ้าเลือกปี
            if ($year) {
                $query->whereYear('due_date', $year);
            }
        }])->get();

        return view('admin.non_payment.non-payment', compact('locations'));
    }

    public function nonPaymentDetail(int $trashLocationId)
    {
        $location = TrashLocation::with(['bills' => function($query) {
            $query->where('status', 'ยังไม่ชำระ'); // เฉพาะบิลยังไม่ชำระ
        }])->findOrFail($trashLocationId);

        // คำนวณยอดรวมค้างชำระ
        $totalPending = $location->bills->sum('amount');

        return view('admin.non_payment.non-payment-detail', compact('location', 'totalPending'));
    }


    public function exportNonPaymentPdf(int $trashLocationId)
    {
        $location = TrashLocation::with(['bills' => function($query) {
            $query->where('status', 'ยังไม่ชำระ');
        }])->findOrFail($trashLocationId);

        // คำนวณยอดรวม
        $totalPending = $location->bills->sum('amount');
        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'THSarabunNew'
        ])
        ->loadView('admin.non_payment.pdf', compact('location', 'totalPending'))
        ->setPaper('a4', 'portrait');


        // ดาวน์โหลด PDF
        // return $pdf->download('non_payment_report_'.$location->id.'.pdf');

        // หรือถ้าอยากเปิดในเบราว์เซอร์
        return $pdf->stream('non_payment_report_'.$location->id.'.pdf');
    }

    public function uploadSlip(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'slip' => 'required|image|max:5120', // สูงสุด 5MB
        ]);

        $bill = Bill::findOrFail($request->bill_id);

        if ($request->hasFile('slip')) {
            $path = $request->file('slip')->store('slips', 'public'); // เก็บใน storage/app/public/slips
            $bill->slip_path = $path;   // ต้องมี column slip_path ในตาราง bills
            $bill->status = 'รอการตรวจสอบ';
            $bill->paid_date = now();
            $bill->save();

            return response()->json(['success' => true, 'message' => 'บันทึกสลิปเรียบร้อยแล้ว']);
        }

        return response()->json(['success' => false, 'message' => 'ไม่พบไฟล์สลิป'], 400);
    }


    public function paymentHistoryList(Request $request)
    {
        $month = $request->input('month_filter');
        $year = $request->input('year_filter');

        // ดึง TrashLocation พร้อมบิลที่ชำระแล้ว
        $locations = TrashLocation::with(['bills' => function($query) use ($month, $year) {
            // $query->where('status', 'ชำระแล้ว');

            if ($month) {
                $query->whereMonth('paid_date', $month);
            }

            if ($year) {
                $query->whereYear('paid_date', $year);
            }
        }])->paginate(10); // pagination 10 รายการต่อหน้า

        return view('admin.payment_history.payment-history', compact('locations', 'month', 'year'));
    }

    public function paymentHistoryDetail(int $trashLocationId, Request $request)
    {
        $month = $request->input('month_filter');
        $year = $request->input('year_filter');

        $location = TrashLocation::findOrFail($trashLocationId);

        $billsQuery = $location->bills()->orderBy('paid_date', 'desc');

        if ($month) {
            $billsQuery->whereMonth('paid_date', $month);
        }

        if ($year) {
            $billsQuery->whereYear('paid_date', $year);
        }

        $bills = $billsQuery->paginate(10);

        return view('admin.payment_history.payment-history-detail', compact('location', 'bills'));
    }

    public function verifyPaymentsList(Request $request)
    {
        $locations = TrashLocation::whereHas('bills', function($query) {
                $query->where('status', 'รอการตรวจสอบ');
            })
            ->with(['bills' => function($query) {
                $query->where('status', 'รอการตรวจสอบ')
                    ->orderBy('paid_date', 'desc');
            }])
            ->paginate(10);

        return view('admin.verify_payment.check-payment', compact('locations'));
    }

    public function dashboard()
    {
        // นับบิลตามสถานะ
        $paidCount = Bill::where('status', 'ชำระแล้ว')->count();
        $unpaidCount = Bill::where('status', 'ยังไม่ชำระ')->count();
        $pendingCount = Bill::where('status', 'รอการตรวจสอบ')->count();

        return view('admin.dashboard', compact('paidCount', 'unpaidCount', 'pendingCount'));
    }

    public function approveBill(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
        ]);

        try {
            $bill = Bill::findOrFail($request->bill_id);
            $bill->status = 'ชำระแล้ว';
            $bill->save();

            return response()->json([
                'success' => true,
                'message' => 'บิลถูกอนุมัติเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
