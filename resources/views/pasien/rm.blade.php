@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Rekam Medis Anda</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full w-full border border-gray-300 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 text-center">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Keluhan</th>
                        <th class="border px-3 py-2">Tanggal Kunjungan</th>
                        <th class="border px-3 py-2">Tanggal Ditangani</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekammedis as $index => $rm)
                        @php $ttv = json_decode($rm->ttv ?? '{}'); @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $rekammedis->firstItem() + $index }}</td>
                            <td class="border px-3 py-2">{{ $rm->kunjungan->keluhan ?? '-' }}</td>
                            <td class="border px-3 py-2">
                                {{ \Carbon\Carbon::parse($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
                            </td>
                            <td class="border px-3 py-2">
                                {{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y H:i') }}
                            </td>
                            <td class="border px-3 py-2 text-center">
                                <!-- Trigger modal -->
                                <button onclick="showModal({{ $rm->id }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal detail -->
                        <div id="modal-{{ $rm->id }}"
                            class="fixed hidden inset-0 bg-gray-800 bg-opacity-50 z-50 overflow-y-auto">
                            <div class="bg-white w-full max-w-xl mx-auto mt-20 p-6 rounded shadow">
                                <h2 class="text-lg font-bold mb-4">Detail Rekam Medis</h2>
                                <p><strong>Keluhan:</strong> {{ $rm->kunjungan->keluhan ?? '-' }}</p>
                                <p><strong>Anamnesa:</strong> {{ $rm->anamnesa ?? '-' }}</p>
                                <p><strong>Diagnosa:</strong> {{ $rm->diagnosis ?? '-' }}</p>
                                <p><strong>Tindakan:</strong> {{ $rm->tindakan ?? '-' }}</p>
                                <p><strong>Hasil Pemeriksaan:</strong></p>
                                <ul class="ml-4 list-disc">
                                    <li>TD: {{ $ttv->tekanan_darah ?? '-' }}</li>
                                    <li>Nadi: {{ $ttv->nadi ?? '-' }}</li>
                                    <li>Suhu: {{ $ttv->suhu ?? '-' }}</li>
                                    <li>RR: {{ $ttv->rr ?? '-' }}</li>
                                    <li>SpO₂: {{ $ttv->spo2 ?? '-' }}</li>
                                    <li>GDA: {{ $ttv->gda ?? '-' }}</li>
                                    <li>Asam Urat: {{ $ttv->asam_urat ?? '-' }}</li>
                                    <li>Kolesterol: {{ $ttv->kolesterol ?? '-' }}</li>
                                </ul>
                                <p><strong>Resep Obat:</strong></p>
                                @if ($rm->resepObat->count())
                                    <ul class="list-disc list-inside">
                                        @foreach ($rm->resepObat as $resep)
                                            <li>{{ $resep->obat->nama_obat ?? '-' }} - {{ $resep->dosis ?? '-' }} -
                                                {{ $resep->aturan_pakai ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>-</p>
                                @endif

                                <div class="mt-4 text-right">
                                    <button onclick="hideModal({{ $rm->id }})"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Belum ada rekam medis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $rekammedis->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>

    <script>
        function showModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }

        function hideModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>
@endsection
