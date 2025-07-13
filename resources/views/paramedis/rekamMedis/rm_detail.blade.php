@extends('layouts.main')

@section('content-header')
    {{-- Tombol PDF di pojok kanan atas --}}
    <div class="max-w-4xl mx-auto flex justify-end mb-2">
        <a href="{{ route('paramedis.rekammedis.pdf', $rm->id) }}" target="_blank"
            class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-red-700 transition shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                <path
                    d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L18.5 9H15zM8 15v-2h1.5a1.5 1.5 0 0 1 0 3H9v1H8v-2zm2.5-.5a.5.5 0 1 0 0 1H11a.5.5 0 1 0 0-1h-.5zm3.5 1.5h1v1h-1v-1zm0-2h1v1h-1v-1zm2 0h1v3h-1v-3z" />
            </svg>
            Download PDF
        </a>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg">
        {{-- Judul --}}
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Detail Rekam Medis</h1>
        </div>

        {{-- Informasi --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div><strong>Nama Pasien:</strong><br>{{ $rm->kunjungan->pasien->user->name ?? '-' }}</div>
            <div><strong>Keluhan:</strong><br>{{ $rm->kunjungan->keluhan ?? '-' }}</div>
            <div><strong>Tanggal
                    Kunjungan:</strong><br>{{ \Carbon\Carbon::parse($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
            </div>
            <div><strong>Tanggal Ditangani:</strong><br>{{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y H:i') }}
            </div>
        </div>

        <hr class="my-4">

        <div class="mb-4">
            <strong>Anamnesa:</strong>
            <p>{{ $rm->anamnesa ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <strong>Diagnosa:</strong>
            <p>{{ $rm->diagnosis ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <strong>Tindakan:</strong>
            <p>{{ $rm->tindakan ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <strong>Hasil Pemeriksaan (TTV):</strong>
            @php $ttv = json_decode($rm->ttv ?? '{}'); @endphp
            <ul class="list-disc list-inside ml-4">
                <li><strong>Tekanan Darah:</strong> {{ $ttv->tekanan_darah ?? '-' }}</li>
                <li><strong>Nadi:</strong> {{ $ttv->nadi ?? '-' }}</li>
                <li><strong>Suhu:</strong> {{ $ttv->suhu ?? '-' }}</li>
                <li><strong>RR:</strong> {{ $ttv->rr ?? '-' }}</li>
                <li><strong>SpO₂:</strong> {{ $ttv->spo2 ?? '-' }}</li>
                <li><strong>GDA:</strong> {{ $ttv->gda ?? '-' }}</li>
                <li><strong>Asam Urat:</strong> {{ $ttv->asam_urat ?? '-' }}</li>
                <li><strong>Kolesterol:</strong> {{ $ttv->kolesterol ?? '-' }}</li>
            </ul>
        </div>

        <div class="mb-4">
            <strong>Resep Obat:</strong>
            @if ($rm->resepObat->count())
                <ul class="list-disc list-inside ml-4 space-y-1">
                    @foreach ($rm->resepObat as $resep)
                        <li>
                            {{ $resep->obat->nama_obat ?? '-' }} -
                            {{ $resep->dosis ?? '-' }} -
                            {{ $resep->aturan_pakai ?? '-' }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>-</p>
            @endif
        </div>
    </div>

    {{-- 🔵 Tombol Kembali di bawah kiri --}}
    <div class="max-w-4xl mx-auto mt-4">
        <a href="{{ route('paramedis.rekammedis.index') }}"
            class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 text-sm font-semibold px-4 py-2 rounded-full border border-blue-300 hover:bg-blue-200 transition">
            ← Kembali ke Daftar Rekam Medis
        </a>
    </div>
@endsection
