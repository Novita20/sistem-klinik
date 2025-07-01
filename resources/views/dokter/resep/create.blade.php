@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">🧾 Buat Resep Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-2xl mx-auto bg-white rounded-xl shadow-md space-y-4">

        {{-- ✅ Notifikasi sukses --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- ❌ Notifikasi error validasi --}}
        @if ($errors->any())
            <div class="p-4 bg-red-100 border border-red-400 text-red-800 rounded shadow">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dokter.resep.store') }}" method="POST">
            @csrf
            <input type="hidden" name="rekam_medis_id" value="{{ $rekamMedis->id }}">

            {{-- Nama Pasien --}}
            <div>
                <label class="block font-medium">Nama Pasien:</label>
                <p class="text-gray-700">{{ $rekamMedis->kunjungan->pasien->user->name ?? '-' }}</p>
            </div>

            {{-- Pilih Obat --}}
            <div>
                <label class="block font-medium">Pilih Obat</label>
                <select name="obat_id" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>-- Pilih Obat --</option>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}">
                            {{ $obat->nama_obat }} (Stok: {{ $obat->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block font-medium">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" min="1" required>
            </div>

            {{-- Dosis --}}
            <div>
                <label class="block font-medium">Dosis</label>
                <input type="text" name="dosis" class="w-full border rounded px-3 py-2"
                    placeholder="Contoh: 500 mg, 1 tablet, 5 ml">
            </div>

            {{-- Aturan Pakai --}}
            <div>
                <label class="block font-medium">Aturan Pakai</label>
                <input type="text" name="aturan_pakai" class="w-full border rounded px-3 py-2"
                    placeholder="Contoh: Sesudah makan">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    💾 Simpan Resep
                </button>
            </div>
        </form>
    </div>
@endsection
