@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 space-y-4">
        {{-- ✅ Flash Message --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- 🔍 Form Pencarian --}}
        <form method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien..."
                class="border px-3 py-2 rounded w-1/3">
            <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Cari</button>
        </form>

        {{-- 📋 Tabel --}}
        <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
            @if ($kunjungan->isEmpty())
                <p class="text-gray-500">Belum ada kunjungan pasien.</p>
            @else
                <table class="min-w-full table-auto border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr class="text-left">
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Pasien</th>
                            <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                            <th class="px-4 py-2 border">Keluhan</th>
                            <th class="px-4 py-2 border">Diagnosis</th>
                            <th class="px-4 py-2 border">Tindakan</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungan as $index => $k)
                            @php
                                $status = $k->status ?? 'belum_ditangani';
                                $diagnosis = $k->rekamMedis->diagnosis ?? null;
                                $tindakan = $k->rekamMedis->tindakan ?? null;
                                $namaPasien = $k->pasien->user->name ?? '-';
                                $tanggal = \Carbon\Carbon::parse($k->tgl_kunjungan)
                                    ->timezone('Asia/Jakarta')
                                    ->format('d-m-Y H:i');
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">
                                    {{ ($kunjungan->currentPage() - 1) * $kunjungan->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-2 border">{{ $namaPasien }}</td>
                                <td class="px-4 py-2 border">{{ $tanggal }}</td>
                                <td class="px-4 py-2 border">{{ $k->keluhan ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $diagnosis ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $tindakan ?? '-' }}</td>
                                <td class="px-4 py-2 border">
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
                                    @if ($diagnosis)
                                        <a href="{{ route('dokter.rekammedis.diagnosis', ['kunjungan_id' => $k->id]) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded whitespace-nowrap">
                                            Edit Diagnosis
                                        </a>
                                    @elseif(in_array($status, ['selesai_pemeriksaan_paramedis', 'anamnesa_dokter']))
                                        <a href="{{ route('dokter.rekammedis.diagnosis', ['kunjungan_id' => $k->id]) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                                            Ke Diagnosis
                                        </a>
                                    @else
                                        <a href="{{ route('dokter.kunjungan.detail', $k->id) }}"
                                            class="bg-gray-500 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 📄 Pagination --}}
                <div class="mt-4">
                    {{ $kunjungan->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
