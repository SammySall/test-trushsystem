<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrashLocation;
use App\Models\TrashRequestHistory;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\LineMessagingController;

class TrashLocationController extends Controller
{
    /**
     * แสดงรายการตำแหน่งติดตั้งถังขยะ พร้อมข้อมูลบิล
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // ค้นหาจากชื่อหรือที่อยู่
        $perPage = $request->input('data_table_length', 10); // จำนวนรายการต่อหน้า, default 10

        $locations = TrashLocation::when($search, function($query, $search){
                $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('address', 'LIKE', "%{$search}%");
            })
            ->with('bills')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends(['search' => $search, 'data_table_length' => $perPage]);

        return view('admin_trash.trash_can_installation.can-install', compact('locations', 'search', 'perPage'));
    }


    /**
     * แสดงรายละเอียดการติดตั้งถังขยะ พร้อมรายการบิล
     */
    public function showCanInstallDetail(int $id)
    {
        $location = TrashLocation::with('bills')->findOrFail($id);

        return view('admin_trash.trash_can_installation.can-install-detail', compact('location'));
    }

    /**
     * แสดงรายละเอียดผู้ติดตั้งถังขยะ
     */
    public function showInstallerDetail(int $id)
    {
        $location = TrashLocation::with('bills')->findOrFail($id);

        return view('admin_trash.trash_installer.trash-installer-detail', compact('location'));
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
    public function installerTrash(Request $request)
    {
        $search = $request->input('search'); // ค้นหาจากชื่อหรือที่อยู่
        $perPage = $request->input('data_table_length', 10); // จำนวนรายการต่อหน้า, default 10

        $locations = TrashLocation::with('bills')
            ->where('status', 'เสร็จสิ้น')
            ->when($search, function($query, $search){
                $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('address', 'LIKE', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends(['search' => $search, 'data_table_length' => $perPage]);

        return view('admin_trash.trash_installer.trash-installer', compact('locations', 'search', 'perPage'));
    }


    public function nonPaymentList(Request $request)
{
    $month = $request->input('month_filter');
    $year = $request->input('year_filter');
    $search = $request->input('search'); // ช่องค้นหา

    $locations = TrashLocation::with(['bills' => function ($query) use ($month, $year) {
        $query->where('status', 'ยังไม่ชำระ');

        if ($month) {
            $query->whereMonth('due_date', $month);
        }

        if ($year) {
            $query->whereYear('due_date', $year);
        }
    }])
        ->whereHas('bills', function ($query) use ($month, $year) {
            $query->where('status', 'ยังไม่ชำระ');

            if ($month) {
                $query->whereMonth('due_date', $month);
            }

            if ($year) {
                $query->whereYear('due_date', $year);
            }
        })
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('address', 'LIKE', "%{$search}%");
            });
        })
        ->orderByDesc('id')
        ->paginate(10)
        ->appends([
            'search' => $search,
            'month_filter' => $month,
            'year_filter' => $year
        ]);

    return view('admin_trash.non_payment.non-payment', compact('locations', 'search', 'month', 'year'));
}


    public function nonPaymentDetail(int $trashLocationId)
    {
        $location = TrashLocation::with(['bills' => function($query) {
            $query->where('status', 'ยังไม่ชำระ'); // เฉพาะบิลยังไม่ชำระ
        }])->findOrFail($trashLocationId);

        // คำนวณยอดรวมค้างชำระ
        $totalPending = $location->bills->sum('amount');

        return view('admin_trash.non_payment.non-payment-detail', compact('location', 'totalPending'));
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
        ->loadView('admin_trash.non_payment.pdf', compact('location', 'totalPending'))
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


        // ========================================
        // 🔔 ส่ง LINE ให้ admin ตามประเภทคำร้อง
        // ========================================
        $lineController = new LineMessagingController();
            // ▶ admin-trash
            $admins = User::where('role', 'admin-trash')
                ->whereNotNull('line_user_id')
                ->get();
            $url = '/admin/verify_payment';


        $adminMessage = "📢 มีการชำระเงินค่าขนะเข้ามา\n"
            . "กรุณาตรวจสอบ\n"
            . "ดูรายละเอียด: "
            . url($url);

        // -------------------------
        // ส่ง LINE
        // -------------------------
        foreach ($admins as $admin) {
            $lineController->pushMessage($admin->line_user_id, $adminMessage);
        }

            return response()->json(['success' => true, 'message' => 'บันทึกสลิปเรียบร้อยแล้ว']);
        }

        return response()->json(['success' => false, 'message' => 'ไม่พบไฟล์สลิป'], 400);
    }


    public function paymentHistoryList(Request $request)
{
    $month = $request->input('month_filter');
    $year = $request->input('year_filter');
    $search = $request->input('search'); // รับค่าค้นหา

    $locations = TrashLocation::with(['bills' => function ($query) use ($month, $year) {
        if ($month) {
            $query->whereMonth('paid_date', $month);
        }
        if ($year) {
            $query->whereYear('paid_date', $year);
        }
    }])
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%");
            });
        })
        ->orderByDesc('id')
        ->paginate(10)
        ->appends(['search' => $search, 'month_filter' => $month, 'year_filter' => $year]); // คงค่าค้นหาไว้เวลาเปลี่ยนหน้า

    return view('admin_trash.payment_history.payment-history', compact('locations', 'month', 'year', 'search'));
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


        $bills = $billsQuery->paginate(10);

        return view('admin_trash.payment_history.payment-history-detail', compact('location','histories', 'bills'));
    }

    public function verifyPaymentsList(Request $request)
{
    $search = $request->input('search');
    $perPage = $request->input('data_table_length', 10); // ค่าเริ่มต้น 10

    $locations = TrashLocation::with(['bills' => function ($query) {
        $query->where('status', 'รอการตรวจสอบ')
              ->orderByDesc('id'); // id ของ Bill มาก → น้อย
    }])
    ->whereHas('bills', function($query) {
        $query->where('status', 'รอการตรวจสอบ');
    })
    ->when($search, function ($query, $search) {
        $query->where(function($q) use ($search) {
            $q->where('address', 'LIKE', "%{$search}%");
        });
    })
    ->orderByDesc('id') // id ของ TrashLocation มาก → น้อย
    ->paginate($perPage)
    ->appends(['search' => $search, 'data_table_length' => $perPage]);


    return view('admin_trash.verify_payment.check-payment', compact('locations', 'search', 'perPage'));
}




    public function dashboard()
    {
        // นับบิลตามสถานะ
        $paidCount = Bill::where('status', 'ชำระแล้ว')->count();
        $unpaidCount = Bill::where('status', 'ยังไม่ชำระ')->count();
        $pendingCount = Bill::where('status', 'รอการตรวจสอบ')->count();

        return view('admin_trash.dashboard', compact('paidCount', 'unpaidCount', 'pendingCount'));
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
            // ส่ง LINE ให้เฉพาะผู้ใช้งานปัจจุบันที่มี line_user_id
        $user = auth()->user();
        if ($user && $user->line_user_id) {
            $typeTitle = getTrashRequestTypeTitle($trashRequest->type);

            $lineMessage = "คำร้องการจ่ายเงินคุณผ่านการอนุมัติแล้ว\nดูรายละเอียด: " . url("user/waste_payment/check-payment");

            $lineController = new LineMessagingController();
            $lineController->pushMessage($user->line_user_id, $lineMessage);
        }

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
