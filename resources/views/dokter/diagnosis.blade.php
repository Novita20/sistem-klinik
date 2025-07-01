@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Diagnosis Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- ✅ Flash Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Jika belum memilih kunjungan --}}
        @if (is_null($kunjungan))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
                <p class="font-semibold text-lg">⚠️ Belum Memilih Kunjungan</p>
                <p>Silakan pilih kunjungan pasien terlebih dahulu melalui menu <strong>Data Kunjungan</strong> untuk memulai
                    diagnosis.</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('dokter.kunjungan') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ➡️ Pergi ke Data Kunjungan
                </a>
            </div>
        @else
            {{-- tampilkan form diagnosis --}}


            {{-- ✅ Jika kunjungan tersedia --}}
            <div class="bg-white p-6 rounded-xl shadow space-y-6">

                {{-- 🧾 Informasi Pasien --}}
                <div>
                    <h2 class="text-xl font-semibold mb-2">👤 Informasi Pasien</h2>
                    <p><strong>Nama:</strong> {{ $kunjungan->pasien->user->name ?? '-' }}</p>
                    <p><strong>NID:</strong> {{ $kunjungan->pasien->user->nid ?? '-' }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $kunjungan->pasien->jenis_kelamin ?? '-' }}</p>
                    <p><strong>Tanggal Lahir:</strong>
                        {{ $kunjungan->pasien->tanggal_lahir ? \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </p>
                </div>

                {{-- 🩺 Detail Kunjungan --}}
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

                {{-- 👨‍⚕️ Anamnesa --}}
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
                    {{-- 🔍 Jika sudah ada rekam medis --}}
                    <div>
                        <h2 class="text-xl font-semibold mb-2">📋 Anamnesa</h2>
                        <p><strong>Isi Anamnesa:</strong> {{ $kunjungan->rekamMedis->anamnesa ?? '-' }}</p>
                    </div>

                    @php
                        $status = $kunjungan->status;
                    @endphp

                    {{-- 🧾 Diagnosis --}}
                    @if (in_array($status, ['selesai_pemeriksaan_paramedis', 'tindakan_dokter', 'anamnesa_dokter']))
                        <div>
                            <h2 class="text-xl font-semibold mt-6 mb-2">🧾 Diagnosis & Tindakan</h2>
                            <form action="{{ route('dokter.rekammedis.update', $kunjungan->rekamMedis->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block font-medium">Diagnosis</label>
                                    <textarea name="diagnosis" class="w-full border rounded px-3 py-2" required>{{ $kunjungan->rekamMedis->diagnosis }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block font-medium">Tindakan</label>
                                    <textarea name="tindakan" class="w-full border rounded px-3 py-2">{{ $kunjungan->rekamMedis->tindakan ?? '' }}</textarea>
                                </div>

                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Simpan Diagnosis
                                </button>

                                @php
                                    $rekamMedisId = optional($kunjungan->rekamMedis)->id;
                                @endphp

                                @if ($rekamMedisId && $status === 'tindakan_dokter')
                                    <div class="mt-4">
                                        <a href="{{ route('dokter.resep.create', $rekamMedisId) }}"
                                            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                                            ➕ Tambah Resep Obat
                                        </a>
                                    </div>
                                @endif

                            </form>
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
        @endempty
</div>
@endsection
