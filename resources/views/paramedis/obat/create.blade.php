@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">🩺 Tambah Data Obat</h1>
        <p class="text-sm text-gray-500">Silakan isi informasi lengkap obat yang akan ditambahkan.</p>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-2xl mx-auto bg-white rounded-lg shadow-md">
        {{-- ✅ Notifikasi Error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 📝 Form Tambah Obat --}}
        <form action="{{ route('obat.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- 📌 Nama Obat --}}
            <div>
                <label for="id_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                <select name="id_obat" id="id_obat"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🔢 Stok --}}
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                <input type="number" name="stok" id="stok" min="0" value="{{ old('stok') }}"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- 📅 Tanggal Transaksi --}}
            <div>
                <label for="tgl_transaksi" class="block text-sm font-medium text-gray-700">Tanggal Input</label>
                <input type="date" name="tgl_transaksi" id="tgl_transaksi"
                    value="{{ old('tgl_transaksi', date('Y-m-d')) }}"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- 📅 Tanggal Kadaluarsa --}}
            <div>
                <label for="expired_at" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
                <input type="date" name="expired_at" id="expired_at" value="{{ old('expired_at') }}"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- 🔘 Tombol Aksi --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('obat.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition duration-150">
                    ← Kembali
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                    💾 Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
