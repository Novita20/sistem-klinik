<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokterResepController extends Controller
{
    public function index()
    {
        return view('dokter.resep');
    }
}
