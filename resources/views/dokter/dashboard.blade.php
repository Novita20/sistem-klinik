@extends('layouts.main')
@section('content-header')
    <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-indigo-800">🩺 Dashboard Dokter</h1>
            <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}.</p>
        </div>

        <div class="mt-2 md:mt-0">
            <span class="bg-white text-primary border border-primary py-2 px-3 rounded text-sm" id="realtime-clock">
                <!-- Waktu realtime akan muncul di sini -->
            </span>
        </div>
    </div>
@endsection


@section('content')
    <div class="p-6 space-y-8">
        {{-- 📌 Ringkasan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-100 p-5 rounded-xl text-center shadow-md">
                <h3 class="text-blue-800 font-semibold">Total Kunjungan</h3>
                <p class="text-3xl font-bold text-blue-900 mt-2">{{ $totalKunjungan }}</p>
            </div>
            <div class="bg-green-100 p-5 rounded-xl text-center shadow-md">
                <h3 class="text-green-800 font-semibold">Rekam Medis</h3>
                <p class="text-3xl font-bold text-green-900 mt-2">{{ $totalRekamMedis }}</p>
            </div>
            <div class="bg-yellow-100 p-5 rounded-xl text-center shadow-md">
                <h3 class="text-yellow-800 font-semibold">Belum Ditangani</h3>
                <p class="text-3xl font-bold text-yellow-900 mt-2">{{ $kunjunganBelumDitangani }}</p>
            </div>
        </div>

        {{-- 📊 Grafik Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            {{-- Grafik Kunjungan Pasien --}}
            <div class="bg-white p-5 rounded-xl shadow-md">
                <h3 class="text-gray-700 font-semibold mb-4">📈 Kunjungan Pasien Minggu Ini</h3>
                <img src="{{ $chartKunjunganUrl }}" alt="Grafik Kunjungan" class="w-full rounded-lg">
            </div>

            {{-- Grafik Penyakit Terbanyak --}}
            <div class="bg-white p-5 rounded-xl shadow-md">
                <h3 class="text-gray-700 font-semibold mb-4">🔍 Penyakit Terbanyak</h3>
                <img src="{{ $chartPenyakitUrl }}" alt="Penyakit Terbanyak" class="w-full rounded-lg">
            </div>
        </div>


        {{-- 📅 Jadwal Praktik Dokter --}}
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-gray-700 font-semibold mb-4">📅 Jadwal Praktik Anda</h3>
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                <li><strong>Senin - Rabu:</strong> 08.00 - 12.00</li>
                <li><strong>Kamis:</strong> 08.00 - 14.00</li>
                <li><strong>Jumat:</strong> 09.00 - 11.00</li>
                <li><strong>Sabtu:</strong> 08.00 - 10.00</li>
            </ul>
        </div>

        {{-- 🧾 Tindakan Terakhir --}}
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-gray-700 font-semibold mb-4">🧾 5 Pemeriksaan Terakhir</h3>
            <table class="w-full text-sm border border-gray-300">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="border px-3 py-2">Pasien</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekamTerakhir as $rm)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $rm->kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y') }}</td>
                            <td class="border px-3 py-2">{{ $rm->diagnosis ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 py-3">Belum ada pemeriksaan terbaru</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

            document.getElementById('realtime-clock').innerHTML =
                `<span class="text-secondary">${hariIni}, ${tanggal} ${bulanIni} ${tahun} • </span><span class="text-primary fw-bold">${jam}:${menit}:${detik}</span>`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endpush
