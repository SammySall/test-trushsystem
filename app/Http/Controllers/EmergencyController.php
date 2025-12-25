<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emergency;
use Illuminate\Support\Facades\Storage;

class EmergencyController extends Controller
{
    public function showForm($type = '')
    {
        return view('user.emergency', compact('type'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'salutation' => 'required|string',
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('emergency_pictures', 'public');
        }

        Emergency::create([
            'type' => $request->salutation,
            'name' => $request->name,
            'tel' => $request->tel,
            'description' => $request->description,
            'picture' => $picturePath,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        
        // ========================================
        // 🔔 ส่ง LINE ให้ admin ตามประเภทคำร้อง
        // ========================================
        $emergencyNames = [
            'accident' => 'อุบัติเหตุ',
            'fire' => 'ไฟไหม้',
            'tree-fall' => 'ต้นไม้ล้ม',
            'broken-road' => 'ถนนเสีย',
            'elec-broken' => 'ไฟเสีย',
        ];
        $typeTitle = $emergencyNames($trashRequest->type);

        $lineController = new LineMessagingController();
            // ▶ admin-trash
            $admins = User::where('role', 'admin-trash')
                ->whereNotNull('line_user_id')
                ->get();
            $url = '//admin/emergency/'.$trashRequest->type;


        $adminMessage = "📢 มีการแจ้ง {$typeTitle}\n"
            . "จาก {$trashRequest->fullname}\n"
            . "กรุณาตรวจสอบ\n"
            . "ดูรายละเอียด: "
            . url($url);

        // -------------------------
        // ส่ง LINE
        // -------------------------
        foreach ($admins as $admin) {
            $lineController->pushMessage($admin->line_user_id, $adminMessage);
        }

        return response()->json([
            'success' => true,
            'message' => 'ส่งไปยังหน่วยงานที่เกี่ยวข้องเรียบร้อยแล้ว'
        ]);
    }

    public function emergencyList($type)
    {
        $emergencyNames = [
            'accident' => 'อุบัติเหตุ',
            'fire' => 'ไฟไหม้',
            'tree-fall' => 'ต้นไม้ล้ม',
            'broken-road' => 'ถนนเสีย',
            'elec-broken' => 'ไฟเสีย',
        ];

        $title = $emergencyNames[$type] ?? ucfirst($type);

        // ใช้ paginate แทน get() หรือ all()
        $emergencies = Emergency::where('type', $type)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10); // กำหนดจำนวนต่อหน้า

        return view('admin_emergency.emergency-list', compact('title', 'type', 'emergencies'));
    }

    public function showDetail($id)
    {
        $location = Emergency::findOrFail($id); // ดึงข้อมูลตาม id
        return view('admin_emergency.emergency-detail', compact('location'));
    }

    public function emergencyDashboard()
    {
        // ดึงข้อมูล Emergency ทั้งหมด หรือกรองตาม type ถ้าต้องการ
        $emergencies = Emergency::all();

        // สร้างสรุปจำนวนแต่ละประเภท
        $summary = $emergencies->groupBy('type')->map(function($items) {
            return $items->count();
        });

        return view('admin_emergency.dashboard', compact('summary'));
    }

}
