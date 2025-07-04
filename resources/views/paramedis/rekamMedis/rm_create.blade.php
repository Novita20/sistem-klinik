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
                <p><strong>Nama:</strong> {{ $kunjungan->pasien->user->name ?? '-' }}</p>
                <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan ?? '-' }}</p>
                <p><strong>Tanggal Kunjungan:</strong>
                    {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
                </p>
            </div>

            {{-- Form Rekam Medis --}}
            <form action="{{ route('paramedis.rekammedis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

                {{-- TTV --}}
                <h2 class="text-lg font-semibold text-gray-700">Tanda-Tanda Vital (TTV)</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ([
            'tekanan_darah' => 'Tekanan Darah (mmHg)',
            'suhu' => 'Suhu Tubuh (°C)',
            'nadi' => 'Nadi (/menit)',
            'pernapasan' => 'Pernapasan (/menit)',
            'tinggi_badan' => 'Tinggi Badan (cm)',
            'berat_badan' => 'Berat Badan (kg)',
        ] as $field => $label)
                        <div>
                            <label for="{{ $field }}"
                                class="block text-gray-700 font-medium">{{ $label }}</label>
                            <input
                                type="{{ in_array($field, ['suhu', 'tinggi_badan', 'berat_badan']) ? 'number' : 'text' }}"
                                step="0.1" name="{{ $field }}" id="{{ $field }}"
                                class="w-full mt-1 border border-gray-300 rounded-lg p-2" value="{{ old($field) }}"
                                placeholder="{{ $label }}">
                        </div>
                    @endforeach
                </div>

                {{-- Diagnosa --}}
                <div class="mt-6">
                    <label for="diagnosa" class="block text-gray-700 font-medium">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" rows="3" class="w-full mt-1 border border-gray-300 rounded-lg p-2"
                        required>{{ old('diagnosa') }}</textarea>
                </div>

                {{-- Tindakan --}}
                <div>
                    <label for="tindakan" class="block text-gray-700 font-medium mt-4">Tindakan</label>
                    <textarea name="tindakan" id="tindakan" rows="3" class="w-full mt-1 border border-gray-300 rounded-lg p-2">{{ old('tindakan') }}</textarea>
                </div>

                {{-- Resep Obat --}}
                <div>
                    <label for="resep" class="block text-gray-700 font-medium mt-4">Resep Obat</label>
                    <textarea name="resep" id="resep" rows="2" class="w-full mt-1 border border-gray-300 rounded-lg p-2">{{ old('resep') }}</textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-6">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                    <a href="{{ route('paramedis.kunjungan.index') }}"
                        class="ml-2 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
