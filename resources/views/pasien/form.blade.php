@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Form Kunjungan</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <form action="{{ route('kunjungan.store') }}" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-2xl">
            @csrf

            {{-- Nama Pasien --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Nama</label>
                <input type="text" name="nama" value="{{ $pasien->user->name ?? Auth::user()->name }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>
            </div>

            {{-- NID --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">NID</label>
                <input type="text" name="nid"
                    value="{{ $pasien->user->nid ?? (Auth::user()->nid ?? 'Belum tersedia') }}"
                    class="mt-1 block w-full border rounded px-3 py-2 bg-gray-100" readonly>
            </div>


            {{-- Tanggal & Waktu Kunjungan --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Tanggal & Waktu Kunjungan</label>
                <input type="datetime-local" name="tgl_kunjungan" value="{{ old('tgl_kunjungan') }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
                    required>
                @error('tgl_kunjungan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keluhan --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Keluhan</label>
                <textarea name="keluhan" rows="4" required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">{{ old('keluhan') }}</textarea>
                @error('keluhan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan Kunjungan
                </button>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    <strong>Sukses!</strong> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </form>
    </div>
@endsection
