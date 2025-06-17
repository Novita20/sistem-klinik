@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-2xl shadow-md w-full max-w-3xl mx-auto space-y-6">

            {{-- Nama Pasien --}}
            <div>
                <label class="block text-gray-600 font-semibold">Nama Pasien</label>
                <p class="mt-1 text-gray-900">
                    {{ $kunjungan->pasien?->user?->name ?? '-' }}
                </p>
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label class="block text-gray-600 font-semibold">Tanggal Lahir</label>
                <p class="mt-1 text-gray-900">
                    {{ $kunjungan->pasien?->tanggal_lahir
                        ? \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y')
                        : '-' }}
                </p>
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-gray-600 font-semibold">Jenis Kelamin</label>
                <p class="mt-1 text-gray-900">
                    {{ $kunjungan->pasien?->jenis_kelamin ? ucfirst($kunjungan->pasien->jenis_kelamin) : '-' }}
                </p>
            </div>

            {{-- Keluhan --}}
            <div>
                <label class="block text-gray-600 font-semibold">Keluhan</label>
                <p class="mt-1 text-gray-900">
                    {{ $kunjungan->keluhan ?? '-' }}
                </p>
            </div>

            {{-- Tanggal Kunjungan (Konversi ke WIB) --}}
            <div>
                <label class="block text-gray-600 font-semibold">Tanggal Kunjungan</label>
                <p class="mt-1 text-gray-900">
                    {{ $kunjungan->tgl_kunjungan
                        ? \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i')
                        : '-' }}
                </p>
            </div>

            {{-- Tombol Kembali --}}
            <div class="pt-6">
                <a href="{{ route('paramedis.kunjungan.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-150">
                    ← Kembali ke Data Kunjungan
                </a>
            </div>

        </div>
    </div>
@endsection
