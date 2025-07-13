@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-400 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dokter.kunjungan.update', $kunjungan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Pasien --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Pasien</label>
                    <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                        value="{{ $kunjungan->pasien->user->name ?? '-' }}" readonly>
                </div>

                {{-- Tanggal Kunjungan --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Tanggal Kunjungan</label>
                    <input type="datetime-local" name="tgl_kunjungan" class="w-full border rounded px-3 py-2"
                        value="{{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->format('Y-m-d\TH:i') }}" required>
                </div>

                {{-- Keluhan --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Keluhan</label>
                    <textarea name="keluhan" class="w-full border rounded px-3 py-2" rows="3" required>{{ old('keluhan', $kunjungan->keluhan) }}</textarea>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2" required>
                        @php
                            $statusList = [
                                'belum_ditangani' => 'Belum Ditangani',
                                'anamnesa_dokter' => 'Anamnesa Dokter',
                                'menunggu_pemeriksaan_paramedis' => 'Menunggu Pemeriksaan Paramedis',
                                'selesai_pemeriksaan_paramedis' => 'Selesai Pemeriksaan Paramedis',
                                'tindakan_dokter' => 'Tindakan oleh Dokter',
                                'selesai' => 'Selesai',
                            ];
                        @endphp
                        @foreach ($statusList as $value => $label)
                            <option value="{{ $value }}" {{ $kunjungan->status === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🌡️ Anamnesa / Diagnosis / Tindakan --}}
                @if ($kunjungan->rekamMedis)
                    <hr class="my-4">

                    {{-- Anamnesa --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Anamnesa</label>
                        <textarea name="anamnesa" class="w-full border rounded px-3 py-2" rows="2">{{ old('anamnesa', $kunjungan->rekamMedis->anamnesa) }}</textarea>
                    </div>

                    {{-- Diagnosis --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Diagnosis</label>
                        <textarea name="diagnosis" class="w-full border rounded px-3 py-2" rows="2">{{ old('diagnosis', $kunjungan->rekamMedis->diagnosis) }}</textarea>
                    </div>

                    {{-- Tindakan --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tindakan</label>
                        <textarea name="tindakan" class="w-full border rounded px-3 py-2" rows="2">{{ old('tindakan', $kunjungan->rekamMedis->tindakan) }}</textarea>
                    </div>

                    {{-- Resep Obat --}}
                    @if ($kunjungan->rekamMedis->resepObat && $kunjungan->rekamMedis->resepObat->count() > 0)
                        <div class="mb-4">
                            <label class="block font-medium mb-2">Resep Obat</label>
                            @foreach ($kunjungan->rekamMedis->resepObat as $index => $resep)
                                <div class="border rounded p-3 mb-3">
                                    <p class="mb-2 font-semibold">Obat ke-{{ $loop->iteration }}</p>

                                    <label class="block mb-1 text-sm">Nama Obat</label>
                                    <input type="text" name="reseps[{{ $index }}][obat]"
                                        class="w-full border rounded px-3 py-1 mb-2"
                                        value="{{ $resep->obat->nama_obat ?? '' }}" readonly>

                                    <label class="block mb-1 text-sm">Jumlah</label>
                                    <input type="number" name="reseps[{{ $index }}][jumlah]"
                                        class="w-full border rounded px-3 py-1 mb-2" value="{{ $resep->jumlah }}"
                                        min="1">

                                    <label class="block mb-1 text-sm">Dosis</label>
                                    <input type="text" name="reseps[{{ $index }}][dosis]"
                                        class="w-full border rounded px-3 py-1 mb-2" value="{{ $resep->dosis }}">

                                    <label class="block mb-1 text-sm">Aturan Pakai</label>
                                    <input type="text" name="reseps[{{ $index }}][aturan_pakai]"
                                        class="w-full border rounded px-3 py-1" value="{{ $resep->aturan_pakai }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                {{-- Tombol --}}
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('dokter.kunjungan') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        ← Kembali
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
