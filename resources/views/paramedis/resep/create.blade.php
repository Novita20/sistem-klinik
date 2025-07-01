@extends('layouts.main')

@section('content-header')
<div class="p-4">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Resep Obat</h1>
</div>
@endsection

@section('content')
<div class="p-6">
    <form action="{{ route('resep.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow">
        @csrf

        {{-- Pilih Rekam Medis --}}
        <div>
            <label for="rekam_medis_id" class="block font-medium">Pilih Rekam Medis</label>
            <select name="rekam_medis_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Rekam Medis --</option>
                @foreach ($rekamMedis as $rm)
                <option value="{{ $rm->id }}">
                    RM#{{ $rm->id }} - {{ $rm->kunjungan->user->name ?? 'Pasien Tidak Dikenal' }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Obat --}}
        <div>
            <label for="obat_id" class="block font-medium">Nama Obat</label>
            <select name="obat_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Obat --</option>
                @foreach ($obats as $obat)
                <option value="{{ $obat->id }}">
                    {{ $obat->nama }} (Stok: {{ $obat->stok }})
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Jumlah</label>
            <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" min="1" required>
        </div>

        <div>
            <label class="block font-medium">Keterangan</label>
            <textarea name="keterangan" class="w-full border rounded px-3 py-2" placeholder="Contoh: 3x1 setelah makan"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan Resep
        </button>
    </form>
</div>
@endsection