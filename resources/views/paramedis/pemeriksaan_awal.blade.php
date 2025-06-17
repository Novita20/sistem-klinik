@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Pemeriksaan Awal (TTV & Labor)</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-3xl mx-auto bg-white shadow rounded-2xl">
        <form method="POST" action="#">
            @csrf

            {{-- Tekanan Darah --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Tekanan Darah</label>
                <input type="text" name="tekanan_darah" class="form-input w-full" placeholder="Contoh: 120/80 mmHg">
            </div>

            {{-- Nadi --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Nadi</label>
                <input type="text" name="nadi" class="form-input w-full" placeholder="Contoh: 72 bpm">
            </div>

            {{-- Suhu --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Suhu</label>
                <input type="text" name="suhu" class="form-input w-full" placeholder="Contoh: 36.5 °C">
            </div>

            {{-- Respirasi --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Laju Napas (RR)</label>
                <input type="text" name="rr" class="form-input w-full" placeholder="Contoh: 18 x/menit">
            </div>

            {{-- SpO2 --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">SpO2</label>
                <input type="text" name="spo2" class="form-input w-full" placeholder="Contoh: 98%">
            </div>

            <hr class="my-6">

            <h2 class="text-lg font-bold mb-4">Pemeriksaan Labor Sederhana</h2>

            {{-- GDA --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Gula Darah Acak (GDA)</label>
                <input type="text" name="gda" class="form-input w-full" placeholder="Contoh: 120 mg/dL">
            </div>

            {{-- Asam Urat --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Asam Urat</label>
                <input type="text" name="asam_urat" class="form-input w-full" placeholder="Contoh: 5.5 mg/dL">
            </div>

            {{-- Kolesterol --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Kolesterol</label>
                <input type="text" name="kolesterol" class="form-input w-full" placeholder="Contoh: 180 mg/dL">
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
