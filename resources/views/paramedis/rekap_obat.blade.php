@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Rekap Penggunaan Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-xl shadow w-full overflow-auto">
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">No</th>
                        <th class="p-2">Nama Obat</th>
                        <th class="p-2">Jenis</th>
                        <th class="p-2">Satuan</th>
                        <th class="p-2">Stok Saat Ini</th>
                        <th class="p-2">Masuk</th>
                        <th class="p-2">Keluar</th>
                        <th class="p-2">Frekuensi Digunakan</th>
                        <th class="p-2">Rata-rata/Bulan</th>
                        <th class="p-2">Tanggal Transaksi</th>
                        <th class="p-2">Tanggal Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $obat)
                        <tr class="border-t">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $obat['nama_obat'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['jenis_obat'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['satuan'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['stok'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['total_masuk'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['total_keluar'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['digunakan'] }} kali</td>
                            <td class="px-4 py-2 border">{{ $obat['rata_rata_bulanan'] }}</td>

                            {{-- Tanggal Transaksi --}}
                            <td class="px-4 py-2 border">
                                {{ $obat['terakhir_digunakan'] ? \Carbon\Carbon::parse($obat['terakhir_digunakan'])->format('d-m-Y') : '-' }}
                            </td>

                            {{-- Tanggal Expired --}}
                            <td class="px-4 py-2 border" style="color: {{ $obat['expired_color'] ?? 'inherit' }}">
                                {{ $obat['expired_at'] ? \Carbon\Carbon::parse($obat['expired_at'])->format('d-m-Y') : '-' }}
                            </td>



                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
