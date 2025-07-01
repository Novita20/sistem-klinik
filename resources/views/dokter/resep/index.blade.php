@extends('layouts.main')
@section('content')
    <div class="p-6 max-w-5xl mx-auto bg-white rounded-xl shadow-md space-y-6">

        {{-- ✅ Info Pasien dan Tanggal
        @if ($reseps->isNotEmpty())
            <div class="space-y-1">
                <h2 class="text-lg font-semibold text-gray-800">👤 Pasien:
                    {{ $reseps->first()->rekamMedis->kunjungan->pasien->user->name ?? '-' }}
                </h2>
                <p class="text-sm text-gray-600">
                    🕒 Tanggal Kunjungan:
                    {{ \Carbon\Carbon::parse($reseps->first()->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
                </p>
            </div>
        @endif --}}

        {{-- ✅ Tabel Resep --}}
        @if ($reseps->isEmpty())
            <p class="text-gray-500">Belum ada resep untuk pasien ini.</p>
        @else
            <table class="min-w-full table-auto border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Pasien</th>
                        <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                        <th class="px-4 py-2 border">Nama Obat</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Dosis</th>
                        <th class="px-4 py-2 border">Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($reseps as $resep)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $no++ }}</td>
                            <td class="px-4 py-2 border">{{ $resep->rekamMedis->kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($resep->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-2 border">{{ $resep->obat->nama_obat ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $resep->jumlah }}</td>
                            <td class="px-4 py-2 border">{{ $resep->dosis ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $resep->aturan_pakai ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="text-right">
            <a href="{{ url()->previous() }}"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                ← Kembali
            </a>
        </div>
    </div>
@endsection
