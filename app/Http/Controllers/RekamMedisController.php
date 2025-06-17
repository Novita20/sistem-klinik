<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Ambil pasien yang sedang login
        $user = Auth::user();

        // Ambil semua kunjungan milik pasien
        $rekamMedis = Kunjungan::where('pasien_id', $user->id)
            ->orderBy('tgl_kunjungan', 'desc')
            ->get();

        return view('pasien.rm', compact('rekamMedis'));
    }
}
