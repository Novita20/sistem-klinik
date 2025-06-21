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

            {{-- Tampilkan data pasien --}}
            {{-- Nama --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $pasien->user->name ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                @error('nama')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nid" class="block text-sm font-medium text-gray-700">NID</label>
                <input type="text" name="nid" id="nid" value="{{ old('nid', $pasien->nid ?? '') }}"
                    class="mt-1 block w-full border rounded p-2" />
            </div>


            {{-- Tanggal Lahir --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                @error('tanggal_lahir')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L"
                        {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="P"
                        {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                        Perempuan</option>

                </select>
                @error('jenis_kelamin')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>
            {{-- Tanggal dan Waktu Kunjungan --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Tanggal & Waktu Kunjungan</label>
                <input type="datetime-local" name="tgl_kunjungan" value="{{ old('tgl_kunjungan') }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
                    required>
                @error('tgl_kunjungan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Alamat</label>
                <textarea name="alamat" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $pasien->no_hp ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                @error('no_hp')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Input keluhan --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Keluhan</label>
                <textarea name="keluhan" rows="4" required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">{{ old('keluhan') }}</textarea>
            </div>
            @error('keluhan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror


            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan Kunjungan
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </form>
    </div>
@endsection
