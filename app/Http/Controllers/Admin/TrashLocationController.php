<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrashLocation;

class TrashLocationController extends Controller
{
    public function index()
    {
        $locations = TrashLocation::all();

        // เปลี่ยนชื่อ Blade เป็น caninstall
        return view('caninstall', compact('locations'));
    }

    public function show($id)
    {
        // ดึงข้อมูลจาก DB ตาม ID
        $location = TrashLocation::findOrFail($id);

        return view('detail', compact('location'));
    }

    public function confirmPayment(Request $request, $id)
    {
        try {
            $location = TrashLocation::findOrFail($id);

            $location->status = 1;
            $location->save();

            return response()->json([
                'success' => true,
                'status_text' => 'เสร็จสิ้น'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

