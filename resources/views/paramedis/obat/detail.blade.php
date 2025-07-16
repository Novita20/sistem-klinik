@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Stok: {{ $obat->nama_obat }}</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">

        {{-- Tombol Tambah Batch --}}
        {{-- <div class="mb-4">
            <a href="{{ route('stokobat.create', ['obat_id' => $obat->id]) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah Batch
            </a>
        </div> --}}

        {{-- Tabel Batch Stok --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded shadow">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Stok</th>
                        <th class="py-2 px-4 border">Jenis Mutasi</th>
                        <th class="py-2 px-4 border">Tanggal Input</th>
                        <th class="py-2 px-4 border">Tanggal Kadaluarsa</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obat->logObat as $index => $batch)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border">{{ $batch->jumlah }}</td>
                            <td class="py-2 px-4 border">{{ ucfirst($batch->jenis_mutasi) }}</td>
                            <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($batch->tgl_transaksi)->format('d-m-Y') }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ \Carbon\Carbon::parse($batch->expired_at)->format('d-m-Y') }}
                            </td>

                            <td class="py-2 px-4 border">
                                <a href="{{ route('stokobat.edit', $batch->id) }}"
                                    class="text-yellow-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Belum ada data batch untuk obat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <a href="{{ route('obat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                ← Kembali ke Input Obat
            </a>
        </div>
    </div>
@endsection
