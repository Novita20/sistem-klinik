@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Edit Batch Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-xl mx-auto bg-white rounded-lg shadow-md">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('stokobat.update', $logObat->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Obat (readonly) --}}
            <div class="mb-4">
                <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                <input type="text" id="nama_obat" value="{{ $logObat->obat->nama_obat }}"
                    class="form-input w-full bg-gray-100 cursor-not-allowed" disabled>
            </div>

            {{-- Jumlah (Stok) --}}
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $logObat->jumlah) }}"
                    class="form-input w-full" min="1" required>
            </div>

            {{-- Tanggal Transaksi --}}
            <div class="mb-4">
                <label for="tgl_transaksi" class="block text-sm font-medium text-gray-700">Tanggal Input</label>
                <input type="date" name="tgl_transaksi" id="tgl_transaksi"
                    value="{{ old('tgl_transaksi', \Carbon\Carbon::parse($logObat->tgl_transaksi)->format('Y-m-d')) }}"
                    class="form-input w-full" required>
            </div>

            {{-- Tanggal Kadaluarsa --}}
            <div class="mb-4">
                <label for="expired_at" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
                {{-- ✅ Ini dari relasi obat --}}
                <input type="date" name="expired_at" id="expired_at"
                    value="{{ old('expired_at', \Carbon\Carbon::parse($logObat->expired_at)->format('Y-m-d')) }}"
                    class="form-input w-full" required>

            </div>


            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    💾 Update Batch
                </button>
                <a href="{{ route('obat.detail', $logObat->obat_id) }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">← Kembali</a>
            </div>
        </form>
    </div>
@endsection
