@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-4 rounded-lg shadow">
            @if ($kunjungan->isEmpty())
                <p class="text-gray-500">Belum ada kunjungan pasien.</p>
            @else
                <table class="min-w-full table-auto border">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 border">Nama Pasien</th>
                            <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                            <th class="px-4 py-2 border">Keluhan</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungan as $k)
                            <tr>
                                <td class="px-4 py-2 border">{{ $k->pasien->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    {{ \Carbon\Carbon::parse($k->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-4 py-2 border">{{ $k->keluhan }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($k->status === 'belum ditangani')
                                        <span class="text-red-600 font-semibold">Belum Ditangani</span>
                                    @else
                                        <span class="text-green-600 font-semibold">Sudah Ditangani</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    <a href="{{ route('dokter.kunjungan.show', $k->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
