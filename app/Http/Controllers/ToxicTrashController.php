<?php

namespace App\Http\Controllers;

use App\Models\ToxicTrashLocation;

class ToxicTrashController extends Controller
{
    public function index()
    {
        $locations = ToxicTrashLocation::where('active', 1)->get();

        return view('user.trash-toxic', compact('locations'));
    }
}
