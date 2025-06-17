@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Input Resep Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-2xl shadow-md w-full max-w-3xl mx-auto">
            <form action="#" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nama_pasien" class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                    <input type="text" id="nama_pasien" name="nama_pasien" class="mt-1 block w-full border rounded-md p-2"
                        placeholder="Masukkan nama pasien">
                </div>

                <div class="mb-4">
                    <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat" class="mt-1 block w-full border rounded-md p-2"
                        placeholder="Contoh: Paracetamol">
                </div>

                <div class="mb-4">
                    <label for="dosis" class="block text-sm font-medium text-gray-700">Dosis</label>
                    <input type="text" id="dosis" name="dosis" class="mt-1 block w-full border rounded-md p-2"
                        placeholder="Contoh: 3x1 hari">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Simpan Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
