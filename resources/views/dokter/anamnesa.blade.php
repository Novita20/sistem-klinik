@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Anamnesa / Keluhan</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 bg-white shadow-md rounded-xl">
        @if ($rekamMedis->isEmpty())
            <p class="text-gray-600 italic">Belum ada data anamnesa.</p>
        @else
            <form method="GET" action="{{ route('dokter.rekammedis.anamnesa') }}" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien..."
                    class="p-2 border rounded">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cari</button>
            </form>
            <table class="min-w-full text-sm border">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Nama Pasien</th>
                        <th class="px-4 py-2">Anamnesa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis as $data)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $data->kunjungan->pasien->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $data->anamnesa }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
