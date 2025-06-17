@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Input Rekam Medis Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-2xl shadow-md w-full max-w-3xl mx-auto space-y-6">

            {{-- Informasi Pasien --}}
            <div class="space-y-2">
                <h2 class="text-lg font-semibold text-gray-700">Informasi Pasien</h2>
                <p><strong>Nama:</strong> {{ $kunjungan->pasien?->user?->name ?? '-' }}</p>
                <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan ?? '-' }}</p>
                <p><strong>Tanggal Kunjungan:</strong>
                    {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                </p>
            </div>

            {{-- Form Rekam Medis --}}
            <form action="{{ route('paramedis.rekammedis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

                {{-- Tanda-Tanda Vital --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-700">Tanda-Tanda Vital (TTV)</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="tekanan_darah" class="block text-gray-700 font-medium">Tekanan Darah (mmHg)</label>
                            <input type="text" name="tekanan_darah" id="tekanan_darah"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" placeholder="120/80"
                                value="{{ old('tekanan_darah') }}">
                        </div>
                        <div>
                            <label for="suhu" class="block text-gray-700 font-medium">Suhu Tubuh (°C)</label>
                            <input type="number" step="0.1" name="suhu" id="suhu"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" placeholder="36.5"
                                value="{{ old('suhu') }}">
                        </div>
                        <div>
                            <label for="nadi" class="block text-gray-700 font-medium">Nadi (/menit)</label>
                            <input type="number" name="nadi" id="nadi"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" placeholder="80"
                                value="{{ old('nadi') }}">
                        </div>
                        <div>
                            <label for="pernapasan" class="block text-gray-700 font-medium">Pernapasan (/menit)</label>
                            <input type="number" name="pernapasan" id="pernapasan"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" placeholder="18"
                                value="{{ old('pernapasan') }}">
                        </div>
                        <div>
                            <label for="tinggi_badan" class="block text-gray-700 font-medium">Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" placeholder="170"
                                value="{{ old('tinggi_badan') }}">
                        </div>
                        <div>
                            <label for="berat_badan" class="block text-gray-700 font-medium">Berat Badan (kg)</label>
                            <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" placeholder="60"
                                value="{{ old('berat_badan') }}">
                        </div>
                    </div>
                </div>

                {{-- Diagnosa --}}
                <div>
                    <label for="diagnosa" class="block text-gray-700 font-medium mt-6">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" rows="3"
                        class="w-full mt-1 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200" required>{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tindakan --}}
                <div>
                    <label for="tindakan" class="block text-gray-700 font-medium">Tindakan</label>
                    <textarea name="tindakan" id="tindakan" rows="3"
                        class="w-full mt-1 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200" required>{{ old('tindakan') }}</textarea>
                </div>

                {{-- Resep Obat --}}
                <div>
                    <label for="resep" class="block text-gray-700 font-medium">Resep Obat</label>
                    <textarea name="resep" id="resep" rows="2"
                        class="w-full mt-1 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">{{ old('resep') }}</textarea>
                </div>

                {{-- Tombol Simpan --}}
                <div class="pt-4">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg">
                        Simpan Rekam Medis
                    </button>
                    <a href="{{ route('paramedis.kunjungan.index') }}"
                        class="ml-2 inline-block bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
