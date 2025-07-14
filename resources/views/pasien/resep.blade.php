@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">📄 Resep Obat Anda</h1>
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

            @php
                // Group resep obat berdasarkan rekam medis ID
                $grouped = $resepObat->groupBy('rekam_medis_id');
            @endphp

            @if ($grouped->isEmpty())
                <div class="text-center text-gray-600">Belum ada resep obat yang tersedia.</div>
            @else
                <table class="min-w-[1000px] w-full border border-gray-300 text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 text-center">
                        <tr>
                            <th class="border px-3 py-2">No.</th>
                            <th class="border px-3 py-2">Tanggal Kunjungan</th>
                            <th class="border px-3 py-2">Keluhan</th>
                            <th class="border px-3 py-2">Nama Obat</th>
                            <th class="border px-3 py-2">Jumlah</th>
                            <th class="border px-3 py-2">Dosis</th>
                            <th class="border px-3 py-2">Aturan Pakai</th>
                            <th class="border px-3 py-2">Tanggal Diberikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped as $index => $group)
                            @php
                                $first = $group->first();
                                $kunjungan = optional($first->rekamMedis->kunjungan);
                            @endphp
                            <tr class="hover:bg-gray-50 align-top">
                                <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border px-3 py-2 text-center">
                                    {{ $kunjungan && $kunjungan->tgl_kunjungan
                                        ? \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>
                                <td class="border px-3 py-2">{{ $kunjungan->keluhan ?? '-' }}</td>
                                <td class="border px-3 py-2">
                                    <ul class="list-disc list-inside">
                                        @foreach ($group as $resep)
                                            <li>{{ $resep->obat->nama_obat ?? 'Obat Tidak Ditemukan' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="border px-3 py-2">
                                    <ul class="list-disc list-inside">
                                        @foreach ($group as $resep)
                                            <li>{{ $resep->jumlah }} tablet</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="border px-3 py-2">
                                    <ul class="list-disc list-inside">
                                        @foreach ($group as $resep)
                                            <li>{{ $resep->dosis ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="border px-3 py-2">
                                    <ul class="list-disc list-inside">
                                        @foreach ($group as $resep)
                                            <li>{{ $resep->aturan_pakai ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    {{ \Carbon\Carbon::parse($first->created_at)->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
