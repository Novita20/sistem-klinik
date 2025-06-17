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
                        <th class="p-2">Terakhir Digunakan</th>
                        <th class="p-2">Exp Terdekat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $obat)
                        <tr class="border-t">
                            <td class="p-2">{{ $index + 1 }}</td>
                            <td class="p-2">{{ $obat['nama_obat'] }}</td>
                            <td class="p-2">{{ $obat['jenis_obat'] }}</td>
                            <td class="p-2">{{ $obat['satuan'] }}</td>
                            <td class="p-2">{{ $obat['stok'] }}</td>
                            <td class="p-2">{{ $obat['total_masuk'] }}</td>
                            <td class="p-2">{{ $obat['total_keluar'] }}</td>
                            <td class="p-2">{{ $obat['digunakan'] }} kali</td>
                            <td class="p-2">{{ $obat['rata_rata_bulanan'] }}</td>
                            <td class="p-2">{{ $obat['terakhir_digunakan'] ?? '-' }}</td>
                            <td class="p-2">{{ $obat['exp_terdekat'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
