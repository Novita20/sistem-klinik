@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-xl shadow space-y-6">

            {{-- Informasi Pasien --}}
            <div>
                <h2 class="text-xl font-semibold mb-2">👤 Informasi Pasien</h2>
                <p><strong>Nama:</strong> {{ $kunjungan->pasien->user->name ?? '-' }}</p>
                <p><strong>NID:</strong> {{ $kunjungan->pasien->user->nid ?? '-' }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $kunjungan->pasien->jenis_kelamin ?? '-' }}</p>
                <p><strong>Tanggal Lahir:</strong>
                    {{ \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y') }}</p>
            </div>

            {{-- Detail Kunjungan --}}
            <div>
                <h2 class="text-xl font-semibold mb-2">🗓️ Detail Kunjungan</h2>
                <p><strong>Tanggal Kunjungan:</strong>
                    {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                </p>
                <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan ?? '-' }}</p>
                <p><strong>Status:</strong>
                    @if ($kunjungan->status === 'belum ditangani')
                        <span class="text-red-600 font-semibold">Belum Ditangani</span>
                    @else
                        <span class="text-green-600 font-semibold">Sudah Ditangani</span>
                    @endif
                </p>
            </div>

            {{-- Form Pemeriksaan Jika Belum Ditangani --}}
            @if (!$kunjungan->rekamMedis)
                <div>
                    <h2 class="text-xl font-semibold mb-2">📝 Pemeriksaan</h2>
                    <form action="{{ route('dokter.rekammedis.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

                        <div>
                            <label class="block font-medium">TTV</label>
                            <input type="text" name="ttv" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block font-medium">Diagnosa</label>
                            <textarea name="diagnosa" class="w-full border rounded px-3 py-2" required></textarea>
                        </div>

                        <div>
                            <label class="block font-medium">Tindakan</label>
                            <textarea name="tindakan" class="w-full border rounded px-3 py-2" required></textarea>
                        </div>

                        <div>
                            <label class="block font-medium">Resep</label>
                            <textarea name="resep" class="w-full border rounded px-3 py-2"></textarea>
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Simpan Pemeriksaan
                        </button>
                    </form>
                </div>
            @else
                {{-- Tampilkan hasil rekam medis --}}
                <div>
                    <h2 class="text-xl font-semibold mb-2">📋 Rekam Medis</h2>
                    <p><strong>TTV:</strong> {{ $kunjungan->rekamMedis->ttv ?? '-' }}</p>
                    <p><strong>Diagnosa:</strong> {{ $kunjungan->rekamMedis->diagnosa ?? '-' }}</p>
                    <p><strong>Tindakan:</strong> {{ $kunjungan->rekamMedis->tindakan ?? '-' }}</p>
                    <p><strong>Resep:</strong> {{ $kunjungan->rekamMedis->resep ?? '-' }}</p>
                </div>
            @endif

            {{-- Tombol Kembali --}}
            <div>
                <a href="{{ route('dokter.kunjungan') }}"
                    class="inline-block mt-4 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    ← Kembali ke Daftar Kunjungan
                </a>
            </div>
        </div>
    </div>
@endsection
