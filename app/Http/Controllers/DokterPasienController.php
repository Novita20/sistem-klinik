<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DokterPasienController extends Controller
{
    public function index()
    {
        $pasiens = User::where('role', 'pasien')->get();
        return view('dokter.pasien', compact('pasiens'));
    }
}
