@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Riwayat Kunjungan</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        @if (session('error'))
            <div class="mb-4 text-red-600 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if ($riwayat->isEmpty())
            <p class="text-gray-600">Belum ada riwayat kunjungan.</p>
        @else
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Tanggal Kunjungan</th>
                        <th class="border px-4 py-2">Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                        <tr>
                            <td class="border px-4 py-2">
                                {{ \Carbon\Carbon::parse($item->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            <td class="border px-4 py-2">{{ $item->keluhan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
