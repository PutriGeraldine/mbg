<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class UserController extends Controller
{
    public function lihatData()
    {
        $dataSPPG = \App\Models\DataSPPG::all(); // ambil semua data SPPG
        return view('user.user_data', compact('dataSPPG'));
    }
}