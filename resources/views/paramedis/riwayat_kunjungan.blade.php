@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">Nama Pasien</th>
                        <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                        <th class="px-4 py-2 border">Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatKunjungan as $kunjungan)
                        <tr>
                            <td class="px-4 py-2 border">{{ $kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-2 border">{{ $kunjungan->keluhan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada riwayat kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
