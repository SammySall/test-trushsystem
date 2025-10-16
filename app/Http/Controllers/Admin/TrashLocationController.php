<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrashLocation;
use Illuminate\Http\Request;

class TrashLocationController extends Controller
{
    public function index()
    {
        // Eager load bills เพื่อลดจำนวน query
        $locations = TrashLocation::with('bills')->get();

        return view('admin.trash_can_installation.can-install', compact('locations'));
    }

    public function showCanInstallDetail($id)
    {
        $location = TrashLocation::with('bills')->findOrFail($id);

        return view('admin.trash_can_installation.can-install-detail', compact('location'));
    }

    public function showInstallerDetail($id)
    {
        $location = TrashLocation::with('bills')->findOrFail($id);

        return view('admin.trash_installer.trash-installer-detail', compact('location'));
    }

    public function confirmPayment(Request $request, $id)
    {
        try {
            $location = TrashLocation::findOrFail($id);

            $location->status = 'เสร็จสิ้น'; // เปลี่ยนเป็นข้อความตรงกับ Blade
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

    public function installerTrash()
    {
        // ดึงเฉพาะสถานะเสร็จสิ้น และ eager load bills
        $locations = TrashLocation::with('bills')
            ->where('status', 'เสร็จสิ้น')
            ->get();

        return view('admin.trash_installer.trash-installer', compact('locations'));
    }
}
