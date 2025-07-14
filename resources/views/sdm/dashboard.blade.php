@extends('layouts.main')

@section('content-header')
    <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-indigo-800">👥 Dashboard SDM</h1>
            <p class="text-gray-600">Halo, {{ Auth::user()->name }}! Pantau informasi rekam medis dan penggunaan obat dengan
                mudah.</p>
        </div>

        <div class="mt-2 md:mt-0">
            <span class="bg-white text-primary border border-primary py-2 px-3 rounded text-sm" id="realtime-clock">
                <!-- Waktu realtime ditampilkan di sini -->
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="p-6 space-y-6">
        {{-- 🔢 Ringkasan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-indigo-100 p-4 rounded-xl text-center shadow">
                <h3 class="font-semibold text-indigo-800">Total Rekam Medis</h3>
                <p class="text-2xl font-bold text-indigo-900">{{ $totalRekamMedis }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-xl text-center shadow">
                <h3 class="font-semibold text-yellow-800">Obat Telah Digunakan</h3>
                <p class="text-2xl font-bold text-yellow-900">{{ $totalObatDigunakan }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-xl text-center shadow">
                <h3 class="font-semibold text-red-800">Obat Hampir Habis</h3>
                <p class="text-2xl font-bold text-red-900">{{ $obatHampirHabis }}</p>
            </div>
        </div>

        {{-- 📊 Grafik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-md">
                <h3 class="text-gray-700 font-semibold mb-4">📈 Grafik Diagnosa</h3>
                <img src="{{ $chartDiagnosaUrl }}" alt="Grafik Diagnosa" class="w-full rounded-lg">
            </div>

            <div class="bg-white p-5 rounded-xl shadow-md">
                <h3 class="text-gray-700 font-semibold mb-4">💊 Obat Paling Sering Digunakan</h3>
                <img src="{{ $chartObatUrl }}" alt="Grafik Obat" class="w-full rounded-lg">
            </div>
        </div>

        {{-- 🧾 Rekam Medis Terbaru --}}
        <div class="bg-white p-6 mt-4 rounded-xl shadow-sm">
            <h3 class="text-gray-700 font-semibold mb-3">🧾 5 Rekam Medis Terbaru</h3>
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
                            <td colspan="3" class="text-center text-gray-400 py-3">Belum ada data rekam medis terbaru
                            </td>
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
