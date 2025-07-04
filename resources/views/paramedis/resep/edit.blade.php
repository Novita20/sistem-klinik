@extends('layouts.main')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">✏️ Edit Resep Obat</h2>

        <form action="{{ route('paramedis.resep.update', $resep->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')

            {{-- Obat --}}
            <div class="mb-4">
                <label for="obat_id" class="block text-gray-700 font-semibold mb-1">Nama Obat</label>
                <select name="obat_id" id="obat_id" class="w-full border-gray-300 rounded" required>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}" {{ $resep->obat_id == $obat->id ? 'selected' : '' }}>
                            {{ $obat->nama_obat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold mb-1">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1"
                    value="{{ old('jumlah', $resep->jumlah) }}" class="w-full border-gray-300 rounded" required>
            </div>

            {{-- Dosis --}}
            <div class="mb-4">
                <label for="dosis" class="block text-gray-700 font-semibold mb-1">Dosis</label>
                <input type="text" name="dosis" id="dosis" value="{{ old('dosis', $resep->dosis) }}"
                    class="w-full border-gray-300 rounded">
            </div>

            {{-- Aturan Pakai --}}
            <div class="mb-4">
                <label for="aturan_pakai" class="block text-gray-700 font-semibold mb-1">Aturan Pakai</label>
                <input type="text" name="aturan_pakai" id="aturan_pakai"
                    value="{{ old('aturan_pakai', $resep->aturan_pakai) }}" class="w-full border-gray-300 rounded">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('paramedis.resep.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
@endsection
