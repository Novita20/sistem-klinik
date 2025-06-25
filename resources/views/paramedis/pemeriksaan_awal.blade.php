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
                    <th class="px-4 py-2 border">Nama Pasien</th>
                    <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kunjungan as $item)
                    <tr>
                        <td>{{ $item->pasien->user->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_kunjungan)->format('d-m-Y H:i') }}</td>
                        <td>
                            @if ($item->status === 'menunggu_pemeriksaan_paramedis')
                                <a href="{{ route('paramedis.pemeriksaan.awal.show', $item->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Periksa
                                </a>
                            @elseif ($item->status === 'selesai_pemeriksaan_paramedis')
                                <span class="text-green-600 font-semibold">Selesai Diperiksa</span>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">
                            Tidak ada kunjungan yang menunggu pemeriksaan.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection
