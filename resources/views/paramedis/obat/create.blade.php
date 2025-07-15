@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Data Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- Notifikasi --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah Obat --}}
        <form action="{{ route('obat.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="id_obat" class="block text-sm font-medium text-gray-700">Pilih Nama Obat</label>
                <select name="id_obat" id="id_obat" class="form-select mt-1 block w-full rounded" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="stok" class="block font-medium">Stok</label>
                <input type="number" name="stok" id="stok" class="form-input w-full" value="{{ old('stok') }}"
                    min="0" required>
            </div>

            <div class="mb-4">
                <label for="tgl_transaksi" class="block font-medium">Tanggal Input</label>
                <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-input w-full"
                    value="{{ old('tgl_transaksi', date('Y-m-d')) }}" required>
            </div>

            <div class="mb-4">
                <label for="expired_at" class="block font-medium">Tanggal Kadaluarsa</label>
                <input type="date" name="expired_at" id="expired_at" class="form-input w-full"
                    value="{{ old('expired_at') }}" required>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
