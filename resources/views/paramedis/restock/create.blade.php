@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Ajukan Restock Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-2xl mx-auto bg-white shadow rounded-2xl">
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('paramedis.restock.store') }}">
            @csrf

            {{-- Daftar Obat yang ingin diajukan --}}
            <div id="obat-list">
                <div class="obat-item mb-6 border-b pb-4">
                    {{-- Nama Obat --}}
                    <label class="block text-gray-700 font-semibold mb-1">Nama Obat</label>
                    <select name="obat_id[]" class="form-control mb-2" required>
                        <option value="" disabled selected>Pilih Obat</option>
                        @foreach ($obat as $o)
                            <option value="{{ $o->id }}">{{ $o->nama_obat }}</option>
                        @endforeach
                    </select>

                    {{-- Jumlah --}}
                    <label class="block text-gray-700 font-semibold mb-1">Jumlah</label>
                    <input type="number" name="jumlah[]" min="1" class="form-control" required>
                </div>
            </div>

            {{-- Tombol Tambah Obat --}}
            <button type="button" id="tambah-obat"
                class="mb-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                + Tambah Obat
            </button>

            {{-- Tanggal Pengajuan --}}
            <div class="mb-6">
                <label for="tanggal_pengajuan" class="block text-gray-700 font-semibold mb-1">Tanggal & Jam
                    Pengajuan</label>
                <input type="datetime-local" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                    value="{{ old('tanggal_pengajuan', \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d\TH:i')) }}"
                    required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between">
                <a href="{{ route('paramedis.restock.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                    ← Kembali
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnTambah = document.getElementById('tambah-obat');
            const container = document.getElementById('obat-list');

            btnTambah.addEventListener('click', function() {
                const firstItem = container.querySelector('.obat-item');
                const clone = firstItem.cloneNode(true);

                // Kosongkan nilai input dan select di clone
                clone.querySelectorAll('select, input').forEach(field => {
                    field.value = '';
                });

                container.appendChild(clone);
            });
        });
    </script>
@endpush
