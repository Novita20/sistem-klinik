@extends('layouts.main')

@section('content')
    <div class="p-6">
        {{-- Header --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">👋 Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 mt-1">Semoga sehat selalu. Berikut ringkasan data Anda:</p>
            </div>
            {{-- Jam Realtime --}}
            <div id="realtime-clock"
                class="mt-4 md:mt-0 text-right text-sm text-gray-700 font-bold bg-white rounded-md px-4 py-2 shadow border border-gray-200">
                <span id="tanggal-text"></span>
                <span class="text-blue-600" id="jam-text"></span>
            </div>


        </div>


        {{-- Ringkasan Kesehatan --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-xl text-center shadow">
                <div class="text-xl font-bold text-blue-600">{{ $totalKunjungan }}</div>
                <div class="text-sm text-gray-700">Total Kunjungan</div>
            </div>

            <div class="bg-green-100 p-4 rounded-xl text-center shadow">
                <div class="text-xl font-bold text-green-600">
                    {{ $tekananDarahTerakhir }}
                </div>
                <div class="text-sm text-gray-700">Tekanan Darah Terakhir</div>
            </div>

            <div class="bg-purple-100 p-4 rounded-xl text-center shadow">
                <div class="text-base font-semibold text-purple-600 truncate">
                    {{ $diagnosaTerakhir }}
                </div>
                <div class="text-sm text-gray-700">Diagnosa Terakhir</div>
            </div>


            <div class="bg-yellow-100 p-4 rounded-xl text-center shadow">
                <div class="text-3xl font-bold {{ $rekamMedisTerakhir ? 'text-yellow-600' : 'text-gray-400' }}">
                    {{ $rekamMedisTerakhir ? '🩺' : '⏳' }}
                </div>
                <div class="text-sm font-semibold text-gray-700">
                    {{ $rekamMedisTerakhir ? 'Anda Sudah Pernah Diperiksa' : 'Belum Ada Pemeriksaan' }}
                </div>

                @if ($rekamMedisTerakhir)
                    <div class="text-xs text-gray-500 mt-1">
                        Pemeriksaan terakhir:
                        {{ \Carbon\Carbon::parse($rekamMedisTerakhir->created_at)->translatedFormat('d F Y, H:i') }}
                    </div>
                @endif
            </div>


        </div>

        {{-- Akses Cepat --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('kunjungan.form') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-xl text-center shadow">
                📝 Form Kunjungan
            </a>
            <a href="{{ route('kunjungan.riwayat') }}"
                class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-xl text-center shadow">
                📖 Riwayat Kunjungan
            </a>
            <a href="{{ route('pasien.resep.index') }}"
                class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-xl text-center shadow">
                💊 Resep Obat
            </a>
            <a href="{{ route('profile.edit') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white p-4 rounded-xl text-center shadow">
                👤 Edit Profil
            </a>
        </div>

        {{-- Riwayat Kunjungan Terakhir --}}
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">📋 Riwayat Kunjungan Terakhir</h2>
            <table class="min-w-full text-sm table-auto border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Keluhan</th>
                        <th class="border px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2">13-07-2025</td>
                        <td class="border px-3 py-2">Sakit Perut</td>
                        <td class="border px-3 py-2 text-green-600">Selesai</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2">28-06-2025</td>
                        <td class="border px-3 py-2">Pusing</td>
                        <td class="border px-3 py-2 text-green-600">Selesai</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Grafik Mini --}}
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">📊 Grafik Dummy: Tekanan Darah</h2>
            <img src="https://quickchart.io/chart?c={type:'line',data:{labels:['Jan','Feb','Mar'],datasets:[{label:'TD Sistolik',data:[120,122,119]},{label:'TD Diastolik',data:[80,78,79]}]}}"
                alt="Grafik Tekanan Darah" class="w-full rounded shadow">
        </div>


    </div>
@endsection
@push('scripts')
    <script>
        function updateClock() {
            const now = new Date();

            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];

            const hariIni = hari[now.getDay()];
            const tanggal = now.getDate();
            const bulanIni = bulan[now.getMonth()];
            const tahun = now.getFullYear();

            let jam = now.getHours().toString().padStart(2, '0');
            let menit = now.getMinutes().toString().padStart(2, '0');
            let detik = now.getSeconds().toString().padStart(2, '0');

            // Ubah isi masing-masing span
            document.getElementById('tanggal-text').textContent =
                `${hariIni}, ${tanggal} ${bulanIni} ${tahun} • `;
            document.getElementById('jam-text').textContent =
                `${jam}:${menit}:${detik}`;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Jalankan saat pertama
    </script>
@endpush
