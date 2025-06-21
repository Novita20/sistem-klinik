@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kunjungan Belum Ditangani</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- Flash Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow">
            <table class="min-w-full table-auto border text-sm">
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
                    @forelse ($kunjungan as $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $item->pasien->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($item->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-2 border">{{ $item->keluhan ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                @php
                                    $status = strtolower($item->status ?? 'belum ditangani');
                                @endphp

                                @if ($status === 'belum ditangani')
                                    <span class="text-red-600 font-semibold">Belum Ditangani</span>
                                @elseif ($status === 'sudah ditangani')
                                    <span class="text-green-600 font-semibold">Sudah Ditangani</span>
                                @else
                                    <span class="text-gray-600">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('paramedis.kunjungan.show', $item->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                    Detail
                                </a>
                                <a href="{{ route('paramedis.rekammedis.create', $item->id) }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                    Tangani
                                </a>
                            </td>
                        </tr>
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
