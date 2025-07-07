@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Tambah Obat Baru</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <form action="{{ route('obat.storeBaru') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="nama_obat" value="{{ old('nama_obat') }}" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="jenis_obat">Jenis Obat</label>
                <input type="text" name="jenis_obat" value="{{ old('jenis_obat') }}" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="stok">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan" value="{{ old('satuan') }}" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="expired_at">Tanggal Kadaluarsa</label>
                <input type="date" name="expired_at" value="{{ old('expired_at') }}" class="form-input w-full" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('obat.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
