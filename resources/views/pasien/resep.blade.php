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

            @if ($resepObat->isEmpty())
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
                        @foreach ($resepObat as $resep)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border px-3 py-2 text-center">
                                    {{ optional($resep->rekamMedis->kunjungan)->tgl_kunjungan
                                        ? \Carbon\Carbon::parse($resep->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>
                                <td class="border px-3 py-2">{{ $resep->rekamMedis->kunjungan->keluhan ?? '-' }}</td>
                                <td class="border px-3 py-2">{{ $resep->obat->nama_obat ?? 'Obat Tidak Ditemukan' }}</td>
                                <td class="border px-3 py-2 text-center">{{ $resep->jumlah }} tablet</td>
                                <td class="border px-3 py-2">{{ $resep->dosis ?? '-' }}</td>
                                <td class="border px-3 py-2">{{ $resep->aturan_pakai ?? '-' }}</td>
                                <td class="border px-3 py-2 text-center">
                                    {{ $resep->created_at->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
