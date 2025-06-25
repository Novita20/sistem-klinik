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
                                <td class="px-4 py-2 border">{{ $k->keluhan ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    @php
                                        $status = $k->status ?? 'belum_ditangani';
                                    @endphp

                                    @switch($status)
                                        @case('belum_ditangani')
                                            <span class="text-yellow-600 font-semibold">Belum Ditangani</span>
                                        @break

                                        @case('anamnesa_dokter')
                                            <span class="text-blue-600 font-semibold">Anamnesa Dokter</span>
                                        @break

                                        @case('menunggu_pemeriksaan_paramedis')
                                            <span class="text-indigo-600 font-semibold">Menunggu Pemeriksaan Paramedis</span>
                                        @break

                                        @case('selesai_pemeriksaan_paramedis')
                                            <span class="text-green-600 font-semibold">Selesai Diperiksa Paramedis</span>
                                        @break

                                        @case('tindakan_dokter')
                                            <span class="text-purple-600 font-semibold">Tindakan oleh Dokter</span>
                                        @break

                                        @case('selesai')
                                            <span class="text-gray-700 font-semibold">Selesai</span>
                                        @break

                                        @default
                                            <span class="text-red-700 font-semibold">Status Tidak Dikenal</span>
                                    @endswitch

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
