@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard K3</h1>
        <p class="text-gray-600">Selamat datang di halaman utama K3.</p>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Umum</h2>
            <p class="text-gray-600">
                Anda login sebagai <strong>K3</strong>. Di sini Anda dapat melihat dan mengelola data pasien, hasil
                pemeriksaan, dan jadwal kunjungan.
            </p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-100 p-4 rounded-xl shadow-sm">
                    <h3 class="font-semibold text-blue-800">Total Pasien Hari Ini</h3>
                    <p class="text-2xl font-bold text-blue-900">12</p>
                </div>

                <div class="bg-green-100 p-4 rounded-xl shadow-sm">
                    <h3 class="font-semibold text-green-800">Pemeriksaan Selesai</h3>
                    <p class="text-2xl font-bold text-green-900">7</p>
                </div>
            </div>
        </div>
    </div>
@endsection
