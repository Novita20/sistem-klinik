@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">📋 Riwayat Kunjungan Anda</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            {{-- Data riwayat --}}
            @if ($riwayat->isEmpty())
                <div class="text-center text-gray-600">Belum ada riwayat kunjungan.</div>
            @else
                <table class="min-w-[900px] w-full border border-gray-300 text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 text-center">
                        <tr>
                            <th class="border px-3 py-2">No</th>
                            <th class="border px-3 py-2">Tanggal</th>
                            <th class="border px-3 py-2">Keluhan</th>
                            <th class="border px-3 py-2">Dokter</th>
                            <th class="border px-3 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $kunjungan)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border px-3 py-2">
                                    {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan ?? now())->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </td>
                                <td class="border px-3 py-2">{{ $kunjungan->keluhan ?? '-' }}</td>
                                <td class="border px-3 py-2 text-center">
                                    {{ $kunjungan->rekamMedis && $kunjungan->rekamMedis->dokter ? $kunjungan->rekamMedis->dokter->name : '-' }}
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    @php
                                        $status = $kunjungan->status ?? 'belum_ditangani';
                                    @endphp

                                    @switch($status)
                                        @case('belum_ditangani')
                                            <span class="badge bg-warning text-dark">Belum Ditangani</span>
                                        @break

                                        @case('anamnesa_dokter')
                                            <span class="badge bg-primary">Anamnesa Dokter</span>
                                        @break

                                        @case('menunggu_pemeriksaan_paramedis')
                                            <span class="badge bg-info text-dark">Menunggu Pemeriksaan</span>
                                        @break

                                        @case('selesai_pemeriksaan_paramedis')
                                            <span class="badge bg-secondary">Pemeriksaan Selesai</span>
                                        @break

                                        @case('tindakan_dokter')
                                            <span class="badge bg-primary">Tindakan Dokter</span>
                                        @break

                                        @case('selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @break

                                        @default
                                            <span class="badge bg-dark">-</span>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
