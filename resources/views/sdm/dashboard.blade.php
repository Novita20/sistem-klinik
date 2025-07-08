@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard SDM</h1>
        <p class="text-gray-600">Selamat datang di halaman utama SDM.</p>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Umum</h2>
            <p class="text-gray-600">
                Anda login sebagai <strong>SDM</strong>. Di sini Anda dapat memantau data rekam medis pasien
                dan melihat laporan penggunaan obat tanpa dapat mengubah data.
            </p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-indigo-100 p-4 rounded-xl shadow-sm">
                    <h3 class="font-semibold text-indigo-800">Total Rekam Medis</h3>
                    {{-- <p class="text-2xl font-bold text-indigo-900">{{ $totalRekamMedis }}</p> --}}
                </div>

                <div class="bg-yellow-100 p-4 rounded-xl shadow-sm">
                    <h3 class="font-semibold text-yellow-800">Jumlah Obat Digunakan</h3>
                    {{-- <p class="text-2xl font-bold text-yellow-900">{{ $totalObat }}</p> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
