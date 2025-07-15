@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Stok Obat (Batch)</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-xl bg-white shadow-md rounded">
        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah Batch --}}
        <form action="{{ route('stokobat.store') }}" method="POST">
            @csrf

            {{-- Dropdown Nama Obat --}}
            <div class="mb-4">
                <label for="obat_id" class="block text-sm font-semibold mb-1">Nama Obat</label>
                <select name="obat_id" id="obat_id" class="w-full border rounded px-4 py-2" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Input Stok --}}
            <div class="mb-4">
                <label for="stok" class="block text-sm font-semibold mb-1">Jumlah Stok</label>
                <input type="number" name="stok" id="stok" min="1" class="w-full border rounded px-4 py-2"
                    required>
            </div>

            {{-- Input Tanggal Masuk --}}
            <div class="mb-4">
                <label for="tanggal_input" class="block text-sm font-semibold mb-1">Tanggal Input</label>
                <input type="date" name="tanggal_input" id="tanggal_input" class="w-full border rounded px-4 py-2"
                    required>
            </div>

            {{-- Input Tanggal Kadaluarsa --}}
            <div class="mb-4">
                <label for="expired_at" class="block text-sm font-semibold mb-1">Tanggal Kadaluarsa</label>
                <input type="date" name="expired_at" id="expired_at" class="w-full border rounded px-4 py-2" required>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Simpan Batch
                </button>
            </div>
        </form>
    </div>
@endsection
