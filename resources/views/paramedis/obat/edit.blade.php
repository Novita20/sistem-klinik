@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Edit Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <form action="{{ route('obat.update', $obat->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                    class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="jenis_obat">Jenis Obat</label>
                <input type="text" name="jenis_obat" value="{{ old('jenis_obat', $obat->jenis_obat) }}"
                    class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="stok">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan" value="{{ old('satuan', $obat->satuan) }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="created_at">Tanggal Input</label>
                <input type="text" value="{{ \Carbon\Carbon::parse($obat->created_at)->format('d-m-Y H:i') }}"
                    class="form-input w-full bg-gray-100 cursor-not-allowed" readonly>
            </div>

            <div class="mb-4">
                <label for="expired_at">Tanggal Kadaluarsa</label>
                <input type="date" name="expired_at"
                    value="{{ old('expired_at', \Carbon\Carbon::parse($obat->expired_at)->format('Y-m-d')) }}"
                    class="form-input w-full">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('obat.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
