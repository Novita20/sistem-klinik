@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Pemeriksaan Awal (TTV & Labor)</h1>
        <p class="text-gray-500">Pasien: <strong>{{ $kunjungan->pasien->user->name ?? '-' }}</strong></p>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-3xl mx-auto bg-white shadow rounded-2xl">

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('paramedis.pemeriksaan.awal.store') }}">
            @csrf
            <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

            {{-- TTV --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Tekanan Darah</label>
                <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah') }}" class="form-input w-full"
                    placeholder="Contoh: 120/80 mmHg">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Nadi</label>
                <input type="text" name="nadi" value="{{ old('nadi') }}" class="form-input w-full"
                    placeholder="Contoh: 72 bpm">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Suhu</label>
                <input type="text" name="suhu" value="{{ old('suhu') }}" class="form-input w-full"
                    placeholder="Contoh: 36.5 °C">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Laju Napas (RR)</label>
                <input type="text" name="rr" value="{{ old('rr') }}" class="form-input w-full"
                    placeholder="Contoh: 18 x/menit">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">SpO2</label>
                <input type="text" name="spo2" value="{{ old('spo2') }}" class="form-input w-full"
                    placeholder="Contoh: 98%">
            </div>

            <hr class="my-6">

            {{-- Pemeriksaan Labor --}}
            <h2 class="text-lg font-bold mb-4">Pemeriksaan Labor Sederhana</h2>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Gula Darah Acak (GDA)</label>
                <input type="text" name="gda" value="{{ old('gda') }}" class="form-input w-full"
                    placeholder="Contoh: 120 mg/dL">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Asam Urat</label>
                <input type="text" name="asam_urat" value="{{ old('asam_urat') }}" class="form-input w-full"
                    placeholder="Contoh: 5.5 mg/dL">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Kolesterol</label>
                <input type="text" name="kolesterol" value="{{ old('kolesterol') }}" class="form-input w-full"
                    placeholder="Contoh: 180 mg/dL">
            </div>

            {{-- Submit --}}
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
@endsection
