@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Daftar Rekam Medis</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="mb-4">
            <form method="GET" action="{{ route('paramedis.rekammedis.index') }}" class="flex flex-wrap gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama pasien..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('paramedis.rekammedis.index') }}"
                        class="text-sm text-red-500 ml-2 hover:underline">Reset</a>
                @endif
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-[1300px] w-full border border-gray-300 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 text-center">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Nama Pasien</th>
                        <th class="border px-3 py-2">Keluhan</th>
                        <th class="border px-3 py-2">Anamnesa</th>
                        <th class="border px-3 py-2">Diagnosa</th>
                        <th class="border px-3 py-2">Tindakan</th>
                        <th class="border px-3 py-2">Hasil Pemeriksaan</th>
                        <th class="border px-3 py-2">Resep Obat</th>
                        <th class="border px-3 py-2">Tanggal Kunjungan</th>
                        <th class="border px-3 py-2">Tanggal Ditangani</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekammedis as $index => $rm)
                        @php $ttv = json_decode($rm->ttv ?? '{}'); @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $rekammedis->firstItem() + $index }}</td>
                            <td class="border px-3 py-2">{{ $rm->kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $rm->kunjungan->keluhan ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $rm->anamnesa ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $rm->diagnosis ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $rm->tindakan ?? '-' }}</td>
                            <td class="border px-3 py-2 leading-tight">
                                <div><strong>TD:</strong> {{ $ttv->tekanan_darah ?? '-' }}</div>
                                <div><strong>Nadi:</strong> {{ $ttv->nadi ?? '-' }}</div>
                                <div><strong>Suhu:</strong> {{ $ttv->suhu ?? '-' }}</div>
                                <div><strong>RR:</strong> {{ $ttv->rr ?? '-' }}</div>
                                <div><strong>SpO₂:</strong> {{ $ttv->spo2 ?? '-' }}</div>
                                <div><strong>GDA:</strong> {{ $ttv->gda ?? '-' }}</div>
                                <div><strong>Asam Urat:</strong> {{ $ttv->asam_urat ?? '-' }}</div>
                                <div><strong>Kolesterol:</strong> {{ $ttv->kolesterol ?? '-' }}</div>
                            </td>
                            <td class="border px-3 py-2">
                                @if ($rm->resepObat->count())
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($rm->resepObat as $resep)
                                            <li>{{ $resep->obat->nama_obat ?? '-' }} - {{ $resep->dosis ?? '-' }} -
                                                {{ $resep->aturan_pakai ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border px-3 py-2">
                                {{ \Carbon\Carbon::parse($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}</td>
                            <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y H:i') }}
                            </td>
                            <td class="border px-3 py-2 text-center whitespace-nowrap">
                                <div class="flex flex-col sm:flex-row justify-center gap-1">
                                    <a href="{{ route('paramedis.rekammedis.edit', $rm->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-xs">Edit</a>
                                    <form action="{{ route('paramedis.rekammedis.destroy', $rm->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-gray-500 py-4">Belum ada data rekam medis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $rekammedis->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
