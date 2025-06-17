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
                <label for="nama_obat" class="block font-medium">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-input w-full"
                    value="{{ old('nama_obat') }}" required>
            </div>

            <div class="mb-4">
                <label for="jenis_obat" class="block font-medium">Jenis Obat</label>
                <select name="jenis_obat" id="jenis_obat" class="form-select w-full" required>
                    <option value="">-- Pilih Jenis Obat --</option>
                    @foreach (['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi', 'Tetes', 'Serbuk', 'Suppositoria', 'Spray'] as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_obat') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="stok" class="block font-medium">Stok</label>
                <input type="number" name="stok" id="stok" class="form-input w-full" value="{{ old('stok') }}"
                    required>
            </div>

            <div class="mb-4">
                <label for="satuan" class="block font-medium">Satuan</label>
                <input type="text" name="satuan" id="satuan" class="form-input w-full" value="{{ old('satuan') }}"
                    required>
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
