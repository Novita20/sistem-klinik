@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Edit Mutasi Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-3xl mx-auto bg-white rounded-xl shadow-md">
        <form action="{{ route('logobat.update', $log->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="obat_id" class="block font-medium text-sm text-gray-700">Nama Obat</label>
                <input type="text" value="{{ $log->obat->nama_obat ?? '-' }}" disabled
                    class="form-input w-full rounded border-gray-300 bg-gray-100" />
            </div>

            <div class="mb-4">
                <label for="jenis_mutasi" class="block font-medium text-sm text-gray-700">Jenis Mutasi</label>
                <select name="jenis_mutasi" id="jenis_mutasi" class="form-select w-full rounded border-gray-300">
                    <option value="masuk" {{ $log->jenis_mutasi == 'masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="keluar" {{ $log->jenis_mutasi == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block font-medium text-sm text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ $log->jumlah }}"
                    class="form-input w-full rounded border-gray-300" required />
            </div>

            <div class="mb-4">
                <label for="stok_awal" class="block font-medium text-sm text-gray-700">Stok Awal</label>
                <input type="number" name="stok_awal" id="stok_awal" value="{{ $log->stok_awal }}"
                    class="form-input w-full rounded border-gray-300" required />
            </div>

            <div class="mb-4">
                <label for="sisa_stok" class="block font-medium text-sm text-gray-700">Sisa Stok</label>
                <input type="number" name="sisa_stok" id="sisa_stok" value="{{ $log->sisa_stok }}"
                    class="form-input w-full rounded border-gray-300" required />
            </div>

            <div class="mb-4">
                <label for="tgl_transaksi" class="block font-medium text-sm text-gray-700">Tanggal Transaksi</label>
                <input type="date" name="tgl_transaksi" id="tgl_transaksi"
                    value="{{ \Carbon\Carbon::parse($log->tgl_transaksi)->format('Y-m-d') }}"
                    class="form-input w-full rounded border-gray-300" required />
            </div>

            <div class="mb-4">
                <label for="expired_at" class="block font-medium text-sm text-gray-700">Tanggal Expired</label>
                <input type="date" name="expired_at" id="expired_at"
                    value="{{ $log->expired_at ? \Carbon\Carbon::parse($log->expired_at)->format('Y-m-d') : '' }}"
                    class="form-input w-full rounded border-gray-300" />
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="form-textarea w-full rounded border-gray-300">{{ $log->keterangan }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('logobat.mutasi') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
