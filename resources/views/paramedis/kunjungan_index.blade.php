@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kunjungan Belum Ditangani</h1>
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
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kunjungan as $kunjungan)
                        @if ($kunjungan->status === 'belum ditangani')
                            <tr>
                                <td class="px-4 py-2 border">{{ $kunjungan->pasien->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    {{ $kunjungan->tgl_kunjungan
                                        ? \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i')
                                        : '-' }}
                                </td>
                                <td class="px-4 py-2 border">{{ $kunjungan->keluhan }}</td>
                                <td class="px-4 py-2 border">
                                    <span class="text-red-600 font-semibold">Belum Ditangani</span>
                                </td>
                                <td class="px-4 py-2 border space-x-2">
                                    <a href="{{ route('paramedis.kunjungan.show', $kunjungan->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                        Detail
                                    </a>
                                    <a href="{{ route('paramedis.rekammedis.create', $kunjungan->id) }}"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                        Tangani
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada kunjungan yang perlu
                                ditangani saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
