@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Hasil TTV & Labor</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 bg-white shadow rounded-xl">
        @if ($rekamMedis->isEmpty())
            <p class="text-gray-500">Belum ada data hasil pemeriksaan TTV & Labor dari paramedis.</p>
        @else
            <table class="min-w-full text-sm border">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">Nama Pasien</th>
                        <th class="px-4 py-2">Tekanan Darah</th>
                        <th class="px-4 py-2">Nadi</th>
                        <th class="px-4 py-2">Suhu</th>
                        <th class="px-4 py-2">RR</th>
                        <th class="px-4 py-2">SpO2</th>
                        <th class="px-4 py-2">GDA</th>
                        <th class="px-4 py-2">Asam Urat</th>
                        <th class="px-4 py-2">Kolesterol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis as $rekam)
                        @php $ttv = json_decode($rekam->ttv) ?? (object)[]; @endphp
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $rekam->kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->tekanan_darah ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->nadi ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->suhu ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->rr ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->spo2 ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->gda ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->asam_urat ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $ttv->kolesterol ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
