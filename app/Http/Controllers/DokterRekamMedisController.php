<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokterRekamMedisController extends Controller
{
    public function anamnesa()
    {
        return view('dokter.anamnesa');
    }

    public function ttv()
    {
        return view('dokter.ttv');
    }

    public function diagnosis()
    {
        return view('dokter.diagnosis');
    }

    public function tindakan()
    {
        return view('dokter.tindakan');
    }
}
