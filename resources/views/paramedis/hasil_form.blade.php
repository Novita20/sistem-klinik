@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-2xl shadow-md space-y-6">

            {{-- 👤 Informasi Pasien --}}
            <div>
                <h2 class="text-xl font-semibold mb-2">👤 Informasi Pasien</h2>
                <p><strong>Nama:</strong> {{ $kunjungan->pasien->user->name ?? '-' }}</p>
                <p><strong>NID:</strong> {{ $kunjungan->pasien->user->nid ?? '-' }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ ucfirst($kunjungan->pasien->jenis_kelamin ?? '-') }}</p>
                <p><strong>Tanggal Lahir:</strong>
                    {{ $kunjungan->pasien->tanggal_lahir
                        ? \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y')
                        : '-' }}
                </p>
            </div>

            {{-- 📅 Detail Kunjungan --}}
            <div>
                <h2 class="text-xl font-semibold mb-2">📅 Detail Kunjungan</h2>
                <p><strong>Tanggal Kunjungan:</strong>
                    {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                </p>
                <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan ?? '-' }}</p>
                <p><strong>Status:</strong>
                    <span class="font-semibold text-blue-600">
                        {{ ucwords(str_replace('_', ' ', $kunjungan->status ?? 'Belum Ditangani')) }}
                    </span>
                </p>
            </div>

            {{-- 🩺 Anamnesa Dokter --}}
            @if ($kunjungan->rekamMedis && $kunjungan->rekamMedis->anamnesa)
                <div>
                    <h2 class="text-xl font-semibold mb-2">🩺 Anamnesa dari Dokter</h2>
                    <p><strong>Catatan:</strong> {{ $kunjungan->rekamMedis->anamnesa }}</p>
                </div>
            @endif

            {{-- 🔙 Tombol Kembali --}}
            <div>
                <a href="{{ route('paramedis.kunjungan.index') }}"
                    class="inline-block mt-4 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    ← Kembali ke Daftar Kunjungan
                </a>
            </div>

        </div>
    </div>
@endsection
