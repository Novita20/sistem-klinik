@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pemeriksaan Awal</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 bg-white shadow rounded-2xl">

        <table class="table-auto w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No.</th>
                    <th class="px-4 py-2 border">Nama Pasien</th>
                    <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kunjungan as $item)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $item->pasien->user->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tgl_kunjungan)->format('d-m-Y H:i') }}
                        </td>
                        <td class="border px-4 py-2">
                            @switch($item->status)
                                @case('menunggu_pemeriksaan_paramedis')
                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-sm">Menunggu Pemeriksaan
                                        Paramedis</span>
                                @break

                                @case('selesai_pemeriksaan_paramedis')
                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-sm">Selesai
                                        Pemeriksaan</span>
                                @break

                                @case('anamnesa_dokter')
                                    <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-sm">Sedang Diperiksa
                                        Dokter</span>
                                @break

                                @default
                                    <span
                                        class="bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span>
                            @endswitch
                        </td>
                        <td class="border px-4 py-2">
                            @if ($item->status === 'menunggu_pemeriksaan_paramedis')
                                <a href="{{ route('paramedis.pemeriksaan.awal.show', $item->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Periksa
                                </a>
                            @elseif ($item->status === 'selesai_pemeriksaan_paramedis')
                                <span class="text-green-600 font-semibold">Selesai</span>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Tidak ada kunjungan yang menunggu pemeriksaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
