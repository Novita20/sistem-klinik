@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="p-6">
        <div class="bg-white p-6 rounded-xl shadow space-y-6">

            {{-- 👤 Informasi Pasien --}}
            <div>
                <h2 class="text-xl font-semibold mb-2">👤 Informasi Pasien</h2>
                <p><strong>Nama:</strong> {{ $kunjungan->pasien->user->name ?? '-' }}</p>
                <p><strong>NID:</strong> {{ $kunjungan->pasien->user->nid ?? '-' }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $kunjungan->pasien->jenis_kelamin ?? '-' }}</p>
                <p><strong>Tanggal Lahir:</strong>
                    {{ optional($kunjungan->pasien->tanggal_lahir) ? \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y') : '-' }}
                </p>
            </div>

            {{-- 🗓️ Detail Kunjungan --}}
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

            {{-- 🩺 Anamnesa Dokter --}}
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
                <div>
                    <h2 class="text-xl font-semibold mb-2">📋 Anamnesa</h2>
                    <p><strong>Isi Anamnesa:</strong> {{ $kunjungan->rekamMedis->anamnesa ?? '-' }}</p>
                </div>

                {{-- 🧾 Diagnosa & Tindakan --}}
                @if (
                    $kunjungan->status === 'tindakan_dokter' &&
                        (empty($kunjungan->rekamMedis->diagnosis) || empty($kunjungan->rekamMedis->tindakan)))
                    <div>
                        <h2 class="text-xl font-semibold mt-6 mb-2">🧾 Diagnosa & Tindakan</h2>
                        <form action="{{ route('dokter.rekammedis.update', $kunjungan->rekamMedis->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block font-medium">Diagnosa</label>
                                <textarea name="diagnosis" class="w-full border rounded px-3 py-2" required>{{ old('diagnosis', $kunjungan->rekamMedis->diagnosis) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block font-medium">Tindakan</label>
                                <textarea name="tindakan" class="w-full border rounded px-3 py-2" required>{{ old('tindakan', $kunjungan->rekamMedis->tindakan) }}</textarea>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Simpan Diagnosa & Tindakan
                            </button>
                        </form>
                    </div>
                @else
                    <div>
                        <h2 class="text-xl font-semibold mt-6 mb-2">🧾 Diagnosa & Tindakan</h2>
                        <p><strong>Diagnosa:</strong> {{ $kunjungan->rekamMedis->diagnosis }}</p>
                        <p><strong>Tindakan:</strong> {{ $kunjungan->rekamMedis->tindakan }}</p>
                    </div>
                @endif

                {{-- 💊 Resep Obat --}}
                @php
                    $reseps = optional($kunjungan->rekamMedis)->resepObat;
                @endphp

                @if ($reseps && $reseps->count() > 0)
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold mb-2">💊 Resep Obat</h2>
                        <table class="w-full border text-sm">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1">Nama Obat</th>
                                    <th class="border px-2 py-1">Jumlah</th>
                                    <th class="border px-2 py-1">Dosis</th>
                                    <th class="border px-2 py-1">Aturan Pakai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reseps as $resep)
                                    <tr>
                                        <td class="border px-2 py-1">{{ $resep->obat->nama_obat ?? '-' }}</td>
                                        <td class="border px-2 py-1">{{ $resep->jumlah }}</td>
                                        <td class="border px-2 py-1">{{ $resep->dosis }}</td>
                                        <td class="border px-2 py-1">{{ $resep->aturan_pakai }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="mt-4">
                        <a href="{{ route('dokter.resep.create', $kunjungan->rekamMedis->id) }}"
                            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                            ➕ Tambah Resep Obat
                        </a>
                    </div>
                @endif
            @endif

            {{-- 🔙 Tombol Kembali --}}
            <div>
                <a href="{{ route('dokter.kunjungan') }}"
                    class="inline-block mt-6 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    ← Kembali ke Daftar Kunjungan
                </a>
            </div>
        </div>
    </div>
@endsection
