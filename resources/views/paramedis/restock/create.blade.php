@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Ajukan Restock Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-xl mx-auto bg-white shadow rounded-2xl p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('paramedis.restock.store') }}">
            @csrf

            <div class="mb-3">
                <label for="obat_id" class="form-label">Nama Obat</label>
                <select name="obat_id" id="obat_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Obat</option>
                    @foreach ($obat as $o)
                        <option value="{{ $o->id }}">{{ $o->nama_obat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1"
                    value="{{ old('jumlah') }}">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('paramedis.restock.index') }}" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-primary">Ajukan</button>
            </div>
        </form>
    </div>
@endsection
