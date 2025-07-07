@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Ajukan Restock Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-xl mx-auto bg-white shadow rounded-2xl">
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('paramedis.restock.store') }}">
            @csrf

            {{-- Pilih Obat --}}
            <div class="mb-4">
                <label for="obat_id" class="block text-gray-700 font-semibold mb-1">Nama Obat</label>
                <select name="obat_id" id="obat_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Obat</option>
                    @foreach ($obat as $o)
                        <option value="{{ $o->id }}" {{ old('obat_id') == $o->id ? 'selected' : '' }}>
                            {{ $o->nama_obat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold mb-1">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1" class="form-control"
                    value="{{ old('jumlah') }}" required>
            </div>

            {{-- Tanggal Pengajuan --}}
            <div class="mb-4">
                <label for="tanggal_pengajuan" class="block text-gray-700 font-semibold mb-1">Tanggal & Jam
                    Pengajuan</label>
                <input type="datetime-local" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                    value="{{ old('tanggal_pengajuan', \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d\TH:i')) }}"
                    required>

            </div>



            {{-- Tombol --}}
            <div class="flex justify-between">
                <a href="{{ route('paramedis.restock.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                    ← Kembali
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
@endsection
