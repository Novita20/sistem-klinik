@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Edit Rekam Medis Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-2xl mx-auto">
            {{-- Informasi pasien --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Informasi Pasien</h2>
                <p><strong>Nama Pasien:</strong> {{ $rekammedis->kunjungan->pasien->user->name ?? '-' }}</p>
                <p><strong>Keluhan:</strong> {{ $rekammedis->kunjungan->keluhan ?? '-' }}</p>
                <p><strong>Tanggal Kunjungan:</strong>
                    {{ \Carbon\Carbon::parse($rekammedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}</p>
                <p><strong>Tanggal Ditangani:</strong>
                    {{ \Carbon\Carbon::parse($rekammedis->created_at)->format('d-m-Y H:i') }}</p>
            </div>

            {{-- Form Edit --}}
            <form action="{{ route('paramedis.rekammedis.update', $rekammedis->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="anamnesa" class="block font-semibold mb-1">Anamnesa</label>
                    <textarea id="anamnesa" name="anamnesa"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
                        rows="3">{{ old('anamnesa', $rekammedis->anamnesa) }}</textarea>
                </div>

                <div>
                    <label for="diagnosis" class="block font-semibold mb-1">Diagnosa</label>
                    <input type="text" id="diagnosis" name="diagnosis"
                        value="{{ old('diagnosis', $rekammedis->diagnosis) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="tindakan" class="block font-semibold mb-1">Tindakan</label>
                    <textarea id="tindakan" name="tindakan"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
                        rows="3">{{ old('tindakan', $rekammedis->tindakan) }}</textarea>
                </div>

                <div class="text-right">
                    <a href="{{ route('paramedis.rekammedis.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
