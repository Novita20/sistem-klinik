@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Edit Resep Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-3xl mx-auto bg-white rounded-xl shadow-md space-y-6">
        {{-- Flash message jika ada --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dokter.resep.update', $resep->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Obat --}}
            <div class="mb-4">
                <label for="obat_id" class="block text-gray-700 font-bold mb-2">Nama Obat</label>
                <select name="obat_id" id="obat_id" class="w-full p-2 border rounded">
                    @foreach ($obat as $obat)
                        <option value="{{ $obat->id }}" {{ $obat->id == $resep->obat_id ? 'selected' : '' }}>
                            {{ $obat->nama_obat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-bold mb-2">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $resep->jumlah) }}"
                    class="w-full p-2 border rounded" required>
            </div>

            {{-- Dosis --}}
            <div class="mb-4">
                <label for="dosis" class="block text-gray-700 font-bold mb-2">Dosis</label>
                <input type="text" name="dosis" id="dosis" value="{{ old('dosis', $resep->dosis) }}"
                    class="w-full p-2 border rounded">
            </div>

            {{-- Aturan Pakai --}}
            <div class="mb-4">
                <label for="aturan_pakai" class="block text-gray-700 font-bold mb-2">Aturan Pakai</label>
                <input type="text" name="aturan_pakai" id="aturan_pakai"
                    value="{{ old('aturan_pakai', $resep->aturan_pakai) }}" class="w-full p-2 border rounded">
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('dokter.resep') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">←
                    Batal</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection
