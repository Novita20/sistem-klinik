@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Mutasi Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- Search --}}
        <div class="mb-4 flex justify-end">
            <form action="{{ route('obat.mutasi') }}" method="GET" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama obat..."
                    class="form-input mr-2 rounded border-gray-300 shadow-sm">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white p-4 rounded-xl shadow-md overflow-auto">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Obat</th>
                        <th class="px-4 py-2 border">Jenis Mutasi</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Stok Awal</th>
                        <th class="px-4 py-2 border">Sisa Stok Sekarang</th>
                        <th class="px-4 py-2 border">Tanggal Transaksi</th>
                        <th class="px-4 py-2 border">Tanggal Expired</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                        <th class="px-4 py-2 border">Referensi</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logObat as $index => $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $logObat->firstItem() + $index }}</td>
                            <td class="px-4 py-2 border">{{ $log->obat->nama_obat ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst($log->jenis_mutasi) }}</td>
                            <td class="px-4 py-2 border">{{ $log->jumlah }}</td>


                            @php
                                // Hitung stok awal berdasarkan jenis mutasi
                                $stokAwal =
                                    $log->jenis_mutasi === 'keluar'
                                        ? $log->sisa_stok + $log->jumlah // Kalau keluar, stok awal = sisa + jumlah keluar
                                        : $log->sisa_stok - $log->jumlah; // Kalau masuk, stok awal = sisa - jumlah masuk

                                // Hitung sisa stok hasil dari stok awal agar sesuai logika
                                $sisaStok =
                                    $log->jenis_mutasi === 'keluar'
                                        ? $stokAwal - $log->jumlah
                                        : $stokAwal + $log->jumlah;
                            @endphp

                            <td class="px-4 py-2 border">
                                {{ $stokAwal }}
                            </td>

                            <td class="px-4 py-2 border">
                                {{ $sisaStok }}
                            </td>


                            {{-- <td class="px-4 py-2 border">
                                {{ $log->obat->stok }}
                            </td> --}}

                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($log->tgl_transaksi)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $log->obat->expired_at ? \Carbon\Carbon::parse($log->obat->expired_at)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-4 py-2 border">{{ $log->keterangan }}</td>
                            <td class="px-4 py-2 border">
                                {{ $log->ref_type ? ucfirst($log->ref_type) . ' #' . $log->ref_id : '-' }}
                            </td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('logobat.edit', $log->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-gray-500">Tidak ada data mutasi obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $logObat->links() }}
            </div>
        </div>
    </div>
@endsection
