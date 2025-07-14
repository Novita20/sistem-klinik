@extends('layouts.main')
@section('content-header')
    <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-indigo-800">🛡️ Dashboard K3</h1>
            <p class="text-gray-600">Halo, {{ Auth::user()->name }}! Pantau dan kelola informasi stok obat dengan mudah.</p>
        </div>

        <div class="mt-2 md:mt-0">
            <span class="bg-white text-primary border border-primary py-2 px-3 rounded text-sm" id="realtime-clock">
                <!-- Waktu realtime ditampilkan di sini -->
            </span>
        </div>
    </div>
@endsection


@section('content')
    <div class="p-6 space-y-8">

        {{-- 📊 Ringkasan Data --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-100 p-5 rounded-xl shadow text-center">
                <h3 class="text-blue-800 font-semibold mb-1">Pengajuan Restock Obat</h3>
                <p class="text-3xl font-bold text-blue-900">{{ $totalRestock ?? 0 }}</p>
                <a href="{{ route('paramedis.restock.index') }}"
                    class="inline-block mt-3 text-sm bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700">
                    🔎 Lihat Pengajuan
                </a>
            </div>

            <div class="bg-green-100 p-5 rounded-xl shadow text-center">
                <h3 class="text-green-800 font-semibold mb-1">Laporan Penggunaan Obat</h3>
                <p class="text-3xl font-bold text-green-900">{{ $totalRekapObat ?? 0 }}</p>
                <a href="{{ route('obat.rekap') }}"
                    class="inline-block mt-3 text-sm bg-green-600 text-white px-4 py-1.5 rounded hover:bg-green-700">
                    📄 Lihat Laporan
                </a>
            </div>

            <div class="bg-red-100 p-5 rounded-xl shadow text-center">
                <h3 class="text-red-800 font-semibold mb-1">Obat Hampir Habis</h3>
                <p class="text-3xl font-bold text-red-900">{{ $obatHampirHabis ?? 0 }}</p>
                <a href="{{ route('obat.index') }}"
                    class="inline-block mt-3 text-sm bg-red-600 text-white px-4 py-1.5 rounded hover:bg-red-700">
                    ⚠️ Cek Stok
                </a>
            </div>
        </div>

        {{-- 📊 Grafik Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-5 rounded-xl shadow">
                <h3 class="text-gray-700 font-semibold mb-3">📈 Grafik Restock Minggu Ini</h3>
                <img src="{{ $chartRestockUrl }}" alt="Grafik Restock" class="w-full rounded-lg">
            </div>

            <div class="bg-white p-5 rounded-xl shadow">
                <h3 class="text-gray-700 font-semibold mb-3">💊 Obat Paling Sering Digunakan</h3>
                <img src="{{ $chartObatUrl }}" alt="Grafik Obat Terpakai" class="w-full rounded-lg">
            </div>
        </div>


        {{-- 📝 Info Tambahan --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-700 font-semibold mb-3">📘 Informasi</h3>
            <p class="text-sm text-gray-700 leading-relaxed">
                Dashboard ini menampilkan data pengajuan restock dari paramedis serta laporan penggunaan obat secara
                real-time.
                Pastikan Anda memeriksa obat yang hampir habis agar stok tetap terjaga. Anda juga dapat melihat
                statistik
                grafik
                untuk mengetahui tren pengajuan dan penggunaan obat yang sering digunakan.
            </p>
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
