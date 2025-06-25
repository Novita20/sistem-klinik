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
                    <span class="font-semibold text-blue-600">
                        {{ ucwords(str_replace('_', ' ', $kunjungan->status ?? 'belum ditangani')) }}
                    </span>
                </p>
            </div>

            {{-- Form Anamnesa Dokter --}}
            @if (!$kunjungan->rekamMedis)
                <div>
                    <h2 class="text-xl font-semibold mb-2">🩺 Anamnesa Dokter</h2>
                    <form action="{{ route('dokter.rekammedis.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

                        <div>
                            <label class="block font-medium">Anamnesa</label>
                            <textarea name="anamnesa" class="w-full border rounded px-3 py-2" required></textarea>
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Simpan Anamnesa
                        </button>
                    </form>
                </div>
            @else
                {{-- Jika sudah ada rekam medis --}}
                <div>
                    <h2 class="text-xl font-semibold mb-2">📋 Anamnesa</h2>
                    <p><strong>Isi Anamnesa:</strong> {{ $kunjungan->rekamMedis->anamnesa ?? '-' }}</p>
                </div>

                @if ($kunjungan->status === 'selesai_pemeriksaan_paramedis' || $kunjungan->status === 'tindakan_dokter')
                    {{-- Form Diagnosa & Tindakan --}}
                    <div>
                        <h2 class="text-xl font-semibold mt-6 mb-2">🧾 Diagnosa & Tindakan</h2>
                        <form action="{{ route('dokter.rekammedis.update', $kunjungan->rekamMedis->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block font-medium">Diagnosa</label>
                                <textarea name="diagnosa" class="w-full border rounded px-3 py-2" required>{{ $kunjungan->rekamMedis->diagnosa }}</textarea>
                            </div>

                            <div>
                                <label class="block font-medium">Tindakan</label>
                                <textarea name="tindakan" class="w-full border rounded px-3 py-2" required>{{ $kunjungan->rekamMedis->tindakan }}</textarea>
                            </div>

                            <div>
                                <label class="block font-medium">Resep</label>
                                <textarea name="resep" class="w-full border rounded px-3 py-2">{{ $kunjungan->rekamMedis->resep }}</textarea>
                            </div>

                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Simpan Diagnosa & Tindakan
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-sm text-gray-600 italic">
                        Menunggu hasil pemeriksaan paramedis (TTV, GDS, dll) sebelum dokter melanjutkan diagnosa dan
                        tindakan.
                    </div>
                @endif
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
