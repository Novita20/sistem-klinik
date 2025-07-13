@extends('layouts.main')

@section('content-header')
    {{-- <div class="flex justify-end p-4">
        <a href="{{ route('dokter.kunjungan.pdf', $kunjungan->id) }}" target="_blank"
            class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-red-700 transition shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                <path
                    d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L18.5 9H15zM8 15v-2h1.5a1.5 1.5 0 0 1 0 3H9v1H8v-2zm2.5-.5a.5.5 0 1 0 0 1H11a.5.5 0 1 0 0-1h-.5zm3.5 1.5h1v1h-1v-1zm0-2h1v1h-1v-1zm2 0h1v3h-1v-3z" />
            </svg>
            PDF
        </a>
    </div> --}}
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto mb-2">
        <div class="flex justify-end">
            <a href="{{ route('dokter.kunjungan.pdf', $kunjungan->id) }}" target="_blank"
                class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-red-700 transition shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L18.5 9H15zM8 15v-2h1.5a1.5 1.5 0 0 1 0 3H9v1H8v-2zm2.5-.5a.5.5 0 1 0 0 1H11a.5.5 0 1 0 0-1h-.5zm3.5 1.5h1v1h-1v-1zm0-2h1v1h-1v-1zm2 0h1v3h-1v-3z" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>
    <div class="p-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg">
        <div class="p-4">
            <h1 class="text-2xl font-bold text-gray-800 text-center">Detail Kunjungan Pasien</h1>
            {{-- <p class="text-sm text-gray-500 text-center mt-1">Data kunjungan pasien secara lengkap</p> --}}
        </div>

        {{-- Informasi Pasien & Kunjungan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <strong>Nama Pasien:</strong><br>
                {{ $kunjungan->pasien->user->name ?? '-' }}
            </div>
            <div>
                <strong>NID:</strong><br>
                {{ $kunjungan->pasien->user->nid ?? '-' }}
            </div>
            <div>
                <strong>Jenis Kelamin:</strong><br>
                {{ $kunjungan->pasien->jenis_kelamin ?? '-' }}
            </div>
            <div>
                <strong>Tanggal Lahir:</strong><br>
                {{ optional($kunjungan->pasien->tanggal_lahir) ? \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y') : '-' }}
            </div>
            <div>
                <strong>Tanggal Kunjungan:</strong><br>
                {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
            </div>
            <div>
                <strong>Status:</strong><br>
                <span class="font-semibold text-blue-600">
                    {{ ucwords(str_replace('_', ' ', $kunjungan->status ?? 'belum ditangani')) }}
                </span>
            </div>
            <div class="sm:col-span-2">
                <strong>Keluhan:</strong><br>
                {{ $kunjungan->keluhan ?? '-' }}
            </div>
        </div>

        <hr class="my-4">

        {{-- Anamnesa --}}
        <div class="mb-4">
            <strong>Anamnesa:</strong><br>
            @if (!$kunjungan->rekamMedis)
                <form action="{{ route('dokter.rekammedis.store') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">
                    <textarea name="anamnesa" class="w-full border rounded px-3 py-2" required></textarea>
                    <button type="submit" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Simpan Anamnesa
                    </button>
                </form>
            @else
                <p>{{ $kunjungan->rekamMedis->anamnesa ?? '-' }}</p>
            @endif
        </div>

        {{-- Diagnosa & Tindakan --}}
        @if ($kunjungan->rekamMedis)
            <div class="mb-4">
                <strong>Diagnosa:</strong><br>
                @if (
                    $kunjungan->status === 'tindakan_dokter' &&
                        (empty($kunjungan->rekamMedis->diagnosis) || empty($kunjungan->rekamMedis->tindakan)))
                    <form action="{{ route('dokter.rekammedis.update', $kunjungan->rekamMedis->id) }}" method="POST"
                        class="mt-2">
                        @csrf
                        @method('PUT')
                        <textarea name="diagnosis" class="w-full border rounded px-3 py-2 mb-2" required>{{ old('diagnosis', $kunjungan->rekamMedis->diagnosis) }}</textarea>
                        <strong>Tindakan:</strong>
                        <textarea name="tindakan" class="w-full border rounded px-3 py-2 mb-2" required>{{ old('tindakan', $kunjungan->rekamMedis->tindakan) }}</textarea>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Simpan Diagnosa & Tindakan
                        </button>
                    </form>
                @else
                    <p>{{ $kunjungan->rekamMedis->diagnosis ?? '-' }}</p>
                    <br>
                    <strong>Tindakan:</strong><br>
                    <p>{{ $kunjungan->rekamMedis->tindakan ?? '-' }}</p>
                @endif
            </div>

            {{-- Resep Obat --}}
            <div class="mb-4">
                <strong>Resep Obat:</strong>
                @php $reseps = $kunjungan->rekamMedis->resepObat ?? collect(); @endphp
                @if ($reseps->count() > 0)
                    <ul class="list-disc list-inside ml-4 space-y-1 mt-2">
                        @foreach ($reseps as $resep)
                            <li>
                                {{ $resep->obat->nama_obat ?? '-' }} -
                                {{ $resep->dosis ?? '-' }} -
                                {{ $resep->aturan_pakai ?? '-' }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-2">-</p>
                    <a href="{{ route('dokter.resep.create', $kunjungan->rekamMedis->id) }}"
                        class="inline-block mt-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        ➕ Tambah Resep Obat
                    </a>
                @endif
            </div>
        @endif
    </div>

    <div class="max-w-4xl mx-auto mb-4">
        <a href="{{ route('dokter.kunjungan') }}"
            class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 text-sm font-semibold px-4 py-2 rounded-full border border-blue-300 hover:bg-blue-200 transition">
            ← Kembali ke Daftar Kunjungan
        </a>


    </div>
@endsection
