<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emergency;
use Illuminate\Support\Facades\Storage;

class EmergencyController extends Controller
{
    public function show($value)
    {
        return view('user.emergency-page', ['currentType' => $value]);
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

        return response()->json([
            'success' => true,
            'message' => 'ส่งไปยังหน่วยงานที่เกี่ยวข้องเรียบร้อยแล้ว'
        ]);
    }
}
