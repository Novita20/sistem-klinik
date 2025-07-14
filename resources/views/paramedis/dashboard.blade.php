@extends('layouts.main')

@section('content')
    <div class="container py-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="text-2xl fw-bold text-primary">👩‍⚕️ Selamat Datang, {{ Auth::user()->name }}</h2>
                <p class="text-muted">Semoga harimu menyenangkan. Berikut aktivitas dan data terbaru:</p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-primary border border-primary py-2 px-3" id="realtime-clock"
                    style="font-size: 0.85rem;"></span>
            </div>


        </div>

        {{-- Ringkasan --}}

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            {{-- Total Kunjungan Pasien --}}
            <div class="bg-blue-100 p-4 rounded-xl text-center shadow">
                <div class="text-xl font-bold text-blue-600">{{ $totalKunjungan }}</div>
                <div class="text-sm text-gray-700">Total Kunjungan</div>

            </div>

            {{-- Obat Hampir Habis --}}
            <div class="bg-red-100 p-4 rounded-xl text-center shadow cursor-pointer" data-bs-toggle="modal"
                data-bs-target="#modalObatHabis">
                <div class="text-xl font-bold text-red-600">{{ $jumlahObatHampirHabis }}</div>
                <div class="text-sm text-gray-700">Obat Hampir Habis</div>
            </div>

            {{-- Obat Mendekati Kadaluarsa --}}
            <div class="bg-gray-200 p-4 rounded-xl text-center shadow cursor-pointer" data-bs-toggle="modal"
                data-bs-target="#modalObatKadaluarsa">
                <div class="text-xl font-bold text-gray-700">{{ $jumlahObatKadaluarsa }}</div>
                <div class="text-sm text-gray-800">Obat Mendekati Kadaluarsa</div>
            </div>

            {{-- Total Rekam Medis --}}
            <div class="bg-green-100 p-4 rounded-xl text-center shadow">
                <div class="text-xl font-bold text-green-600">{{ $totalRekamMedis }}</div>
                <div class="text-sm text-gray-700">Total Rekam Medis</div>
            </div>
        </div>

        {{-- <div class="col-md-3 mb-4">
                <div class="card text-center border-start border-primary border-4 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-receipt fs-2 text-primary mb-2"></i>
                        <h6 class="text-primary">Total Resep Obat</h6>
                        <h4 class="fw-bold">{{ $totalResepObat }}</h4>
                    </div>
                </div>
            </div> --}}
    </div>



    {{-- =========================== --}}
    {{-- SECTION: Menu Paramedis --}}
    {{-- =========================== --}}
    <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">🩺 Menu Paramedis</h5>
    <div class="row">
        @php
            $menusParamedis = [
                // [
                //     'icon' => 'bi-person-lines-fill',
                //     'title' => 'Data Kunjungan',
                //     'route' => route('paramedis.kunjungan.index'),
                //     'color' => 'primary',
                // ],
                [
                    'icon' => 'bi-clock-history',
                    'title' => 'Riwayat Kunjungan',
                    'route' => route('paramedis.kunjungan.riwayat'),
                    'color' => 'warning',
                ],
                [
                    'icon' => 'bi-thermometer-half',
                    'title' => 'Pemeriksaan Awal',
                    'route' => route('paramedis.pemeriksaan.awal'),
                    'color' => 'info',
                ],
                [
                    'icon' => 'bi-file-medical',
                    'title' => 'Rekam Medis',
                    'route' => route('paramedis.rekammedis.index'),
                    'color' => 'secondary',
                ],
                [
                    'icon' => 'bi-capsule',
                    'title' => 'Resep Obat',
                    'route' => route('paramedis.resep.index'),
                    'color' => 'success',
                ],
            ];
        @endphp

        @foreach ($menusParamedis as $menu)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-start border-{{ $menu['color'] }} border-4 shadow-sm dashboard-card">
                    <div class="card-body text-center">
                        <i class="bi {{ $menu['icon'] }} display-6 text-{{ $menu['color'] }} mb-2"></i>
                        <h6 class="card-title">{{ $menu['title'] }}</h6>
                        <a href="{{ $menu['route'] }}" class="btn btn-{{ $menu['color'] }} w-100 mt-2">Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    {{-- Grafik --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="bg-white rounded shadow-sm p-3 h-100">
                <h6 class="text-secondary mb-3">📊 Grafik Tekanan Darah Pasien</h6>
                <img src="https://quickchart.io/chart?c={type:'line',data:{labels:['Sen','Sel','Rab'],datasets:[{label:'Sistolik',data:[120,122,118]},{label:'Diastolik',data:[80,78,82]}]}}"
                    alt="Grafik Tekanan Darah" class="img-fluid rounded mx-auto d-block">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="bg-white rounded shadow-sm p-3 h-100">
                <h6 class="text-secondary mb-3">📈 Grafik Jumlah Kunjungan Pasien ({{ date('Y') }})</h6>
                <img src="https://quickchart.io/chart?c={{ urlencode(
                    json_encode([
                        'type' => 'bar',
                        'data' => [
                            'labels' => $bulanLabels,
                            'datasets' => [
                                [
                                    'label' => 'Jumlah Kunjungan',
                                    'data' => $jumlahKunjungan,
                                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                                ],
                            ],
                        ],
                    ]),
                ) }}"
                    alt="Grafik Kunjungan Pasien" class="img-fluid rounded mx-auto d-block">
            </div>
        </div>
    </div>




    {{-- =========================== --}}
    {{-- SECTION: Manajemen Stok Obat --}}
    {{-- =========================== --}}
    <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">💊 Manajemen Stok Obat</h5>
    <div class="row">
        @php
            $menusObat = [
                ['icon' => 'bi-box-seam', 'title' => 'Input Obat', 'route' => route('obat.input'), 'color' => 'info'],
                [
                    'icon' => 'bi-arrow-left-right',
                    'title' => 'Mutasi Obat',
                    'route' => route('logobat.mutasi'),
                    'color' => 'warning',
                ],
                [
                    'icon' => 'bi-clipboard-data',
                    'title' => 'Rekap Obat',
                    'route' => route('obat.rekap'),
                    'color' => 'secondary',
                ],
                [
                    'icon' => 'bi-cart-plus',
                    'title' => 'Pengajuan Restock',
                    'route' => route('paramedis.restock.index'),
                    'color' => 'danger',
                ],
            ];
        @endphp

        @foreach ($menusObat as $menu)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-start border-{{ $menu['color'] }} border-4 shadow-sm dashboard-card">
                    <div class="card-body text-center">
                        <i class="bi {{ $menu['icon'] }} display-6 text-{{ $menu['color'] }} mb-2"></i>
                        <h6 class="card-title">{{ $menu['title'] }}</h6>
                        <a href="{{ $menu['route'] }}" class="btn btn-{{ $menu['color'] }} w-100 mt-2">Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>




    {{-- MODAL: Obat Hampir Habis --}}
    <div class="modal fade" id="modalObatHabis" tabindex="-1" aria-labelledby="modalObatHabisLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">📉 Obat Hampir Habis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-2">
                    <ul class="list-group small">
                        @forelse ($obatHampirHabisList as $obat)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $obat->nama_obat }}
                                <span class="badge bg-danger">{{ $obat->stok }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">Tidak ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL: Obat Kadaluarsa --}}
    <div class="modal fade" id="modalObatKadaluarsa" tabindex="-1" aria-labelledby="modalObatKadaluarsaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">⏳ Obat Mendekati Kadaluarsa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-2">
                    <ul class="list-group small">
                        @forelse ($obatKadaluarsaList as $obat)
                            <li class="list-group-item">
                                <strong>{{ $obat->nama_obat }}</strong><br>
                                <small class="text-muted">Kadaluarsa:
                                    {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->translatedFormat('d M Y') }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">Tidak ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>
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
