<aside class="main-sidebar sidebar-dark-primary elevation-4"
    style="background: linear-gradient(145deg, #1c2e4a, #0d1b2a); box-shadow: 5px 5px 15px rgba(0,0,0,0.2), -5px -5px 15px rgba(0,0,0,0.2);">

    {{-- <!-- Brand Logo -->
    <a href=" " class="brand-link" style="background-color: #1c2e4a; border-bottom: 1px solid #ffffff;">
        <img src="{{ url('assets/dist/img/pln.jpeg') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"
            style="color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"></span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image mb-2">
                <img src="{{ asset('assets/dist/img/plnnp.png') }}" alt="Logo PLN" style="width: 40px; height: auto;">
            </div> --}}

            <div class="info">
                <a href="{{ Auth::user()->role === 'pasien' ? url('/dashboard') : url(Auth::user()->role . '/dashboard') }}"
                    class="d-block" style="color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    Klinik
                </a>
            </div>


        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 sidebar-fixed">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- PASIEN --}}
                @if (Auth::check() && Auth::user()->role === 'pasien')
                    <li class="nav-item">
                        <a href="{{ route('kunjungan.form') }}"
                            class="nav-link {{ request()->routeIs('kunjungan.form') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-notes-medical"></i>
                            <p>Form Kunjungan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kunjungan.riwayat') }}"
                            class="nav-link {{ request()->routeIs('kunjungan.riwayat') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Kunjungan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rekam.medis') }}"
                            class="nav-link {{ request()->routeIs('rekam.medis') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-medical"></i>
                            <p>Rekam Medis</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.resep.index') }}"
                            class="nav-link {{ request()->routeIs('pasien.resep.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Resep Obat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}"
                            class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profil</p>
                        </a>
                    </li>
                @endif




                {{-- PARAMEDIS --}}
                @if (Auth::check() && Auth::user()->role === 'paramedis')
                    @php
                        $routeName = Route::currentRouteName();

                        $isRawatJalan = in_array($routeName, [
                            'paramedis.kunjungan.index',
                            'paramedis.kunjungan.riwayat',
                            'paramedis.pemeriksaan.awal',
                            'paramedis.rekammedis.index',
                            'resep.create',
                            'paramedis.resep.index',
                        ]);

                        $isStokObat = in_array($routeName, [
                            'obat.index',
                            'logobat.mutasi',
                            'obat.rekap',
                            'paramedis.restock.index',
                        ]);

                        $isProfil = $routeName === 'profile.edit';
                    @endphp

                    {{-- 🔷 Modul 1: Rawat Jalan --}}
                    <li class="nav-item has-treeview {{ $isRawatJalan ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link d-flex justify-content-between align-items-center {{ $isRawatJalan ? 'active bg-primary text-white' : 'text-white' }}"
                            style="padding: 10px 15px; border-radius: 6px;">
                            <span><i class="fas fa-clinic-medical me-2"></i> Rawat Jalan</span>
                            <i class="fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('paramedis.kunjungan.index') }}"
                                    class="nav-link {{ $routeName === 'paramedis.kunjungan.index' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-notes-medical nav-icon text-info"></i>
                                    <p>Data Kunjungan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.kunjungan.riwayat') }}"
                                    class="nav-link {{ $routeName === 'paramedis.kunjungan.riwayat' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-history nav-icon text-warning"></i>
                                    <p>Riwayat Kunjungan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.pemeriksaan.awal') }}"
                                    class="nav-link {{ $routeName === 'paramedis.pemeriksaan.awal' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-stethoscope nav-icon text-success"></i>
                                    <p>Pemeriksaan Awal</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.rekammedis.index') }}"
                                    class="nav-link {{ $routeName === 'paramedis.rekammedis.index' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-file-medical nav-icon text-danger"></i>
                                    <p>Rekam Medis</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.resep.index') }}"
                                    class="nav-link {{ $routeName === 'paramedis.resep.index' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-pills nav-icon text-primary"></i>
                                    <p>Daftar Resep Obat</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- 🔷 Modul 2: Manajemen Stok Obat --}}
                    <li class="nav-item has-treeview {{ $isStokObat ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link d-flex justify-content-between align-items-center {{ $isStokObat ? 'active bg-primary text-white' : 'text-white' }}"
                            style="padding: 10px 15px; border-radius: 6px;">
                            <span><i class="fas fa-capsules me-2"></i> Manajemen Stok Obat</span>
                            <i class="fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('obat.index') }}"
                                    class="nav-link {{ $routeName === 'obat.index' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-table nav-icon text-info"></i>
                                    <p>Input Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logobat.mutasi') }}"
                                    class="nav-link {{ $routeName === 'logobat.mutasi' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-exchange-alt nav-icon text-warning"></i>
                                    <p>Mutasi Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('obat.rekap') }}"
                                    class="nav-link {{ $routeName === 'obat.rekap' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-chart-bar nav-icon text-success"></i>
                                    <p>Rekap Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.restock.index') }}"
                                    class="nav-link {{ $routeName === 'paramedis.restock.index' ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-truck-loading nav-icon text-danger"></i>
                                    <p>Pengajuan Restok</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- 🔷 Modul 3: Profil --}}
                    <li class="nav-item has-treeview {{ $isProfil ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link d-flex justify-content-between align-items-center {{ $isProfil ? 'active bg-primary text-white' : 'text-white' }}"
                            style="padding: 10px 15px; border-radius: 6px;">
                            <span><i class="fas fa-user-circle me-2"></i> Profil</span>
                            <i class="fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}"
                                    class="nav-link {{ $isProfil ? 'active bg-light text-primary fw-bold' : 'text-white' }}"
                                    style="padding-left: 30px; border-radius: 5px;">
                                    <i class="fas fa-user nav-icon text-secondary"></i>
                                    <p>Edit Profil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif



                {{-- 🔷 SIDEBAR UNTUK ROLE DOKTER --}}
                @if (Auth::check() && Auth::user()->role === 'dokter')
                    {{-- 📋 Data Pasien --}}
                    <li class="nav-item">
                        <a href="{{ route('dokter.kunjungan') }}"
                            class="nav-link {{ request()->routeIs('dokter.kunjungan') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Data Kunjungan</p>
                        </a>
                    </li>

                    {{-- 🩺 Rekam Medis --}}
                    <li
                        class="nav-item has-treeview
             {{ request()->routeIs('dokter.rekammedis.*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('dokter.rekammedis.*') ? 'active' : '' }}">
                            <i class="fas fa-file-medical nav-icon"></i>
                            <p>
                                Rekam Medis
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dokter.rekammedis.anamnesa') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('dokter.rekammedis.anamnesa') ? 'active' : '' }}">
                                    <i class="fas fa-comment-medical nav-icon"></i>
                                    <p>Anamnesa / Keluhan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokter.rekammedis.ttv') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('dokter.rekammedis.ttv') ? 'active' : '' }}">
                                    <i class="fas fa-heartbeat nav-icon"></i>
                                    <p>Hasil TTV & Labor</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('dokter.rekammedis.diagnosis') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('dokter.rekammedis.diagnosis') ? 'active' : '' }}">
                                    <i class="fas fa-stethoscope nav-icon"></i>
                                    <p>Diagnosis</p>
                                </a>
                            </li>



                            {{-- <li class="nav-item">
                                <a href="{{ route('dokter.rekammedis.tindakan') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('dokter.rekammedis.tindakan') ? 'active' : '' }}">
                                    <i class="fas fa-syringe nav-icon"></i>
                                    <p>Terapi / Tindakan</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>

                    {{-- 💊 Resep Obat --}}
                    <li class="nav-item">
                        {{-- Karena route ini butuh rekam_medis_id, jangan panggil langsung --}}
                        {{-- Alternatifnya, arahkan ke daftar resep --}}
                        <a href="{{ route('dokter.resep') }}"
                            class="nav-link {{ request()->routeIs('dokter.resep') ? 'active' : '' }}">
                            <i class="fas fa-pills nav-icon"></i>
                            <p>Resep Obat</p>
                        </a>
                    </li>


                    {{-- 👤 Profil --}}
                    <li class="nav-item has-treeview {{ request()->routeIs('profile.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <p>
                                Profil
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                    <i class="fas fa-user nav-icon"></i>
                                    <p>Edit Profil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif




                {{-- 🔷 SIDEBAR UNTUK ROLE K3 --}}
                @if (Auth::check() && Auth::user()->role === 'k3')
                    {{-- 📋 Pengajuan Restock Obat --}}
                    <li class="nav-item">
                        <a href="{{ route('k3.restock') }}"
                            class="nav-link {{ request()->routeIs('k3.restock') ? 'active' : '' }}">
                            <i class="fas fa-pills nav-icon"></i>
                            <p>Pengajuan Restock Obat</p>
                        </a>
                    </li>

                    {{-- 📋 Laporan Penggunaan Obat --}}
                    <li class="nav-item">
                        <a href="{{ route('k3.obat') }}"
                            class="nav-link {{ request()->routeIs('k3.obat') ? 'active' : '' }}">
                            <i class="fas fa-notes-medical nav-icon"></i>
                            <p>Laporan Penggunaan Obat</p>
                        </a>
                    </li>

                    {{-- 👤 Profil --}}
                    <li class="nav-item has-treeview {{ request()->routeIs('profile.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <p>
                                Profil
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                    <i class="fas fa-user nav-icon"></i>
                                    <p>Edit Profil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif



                {{-- 🔷 SIDEBAR UNTUK ROLE SDM --}}
                @if (Auth::check() && Auth::user()->role === 'sdm')
                    <li class="nav-item">
                        <a href="{{ route('sdm.rekammedis.index') }}"
                            class="nav-link {{ request()->routeIs('sdm.rekammedis.index') ? 'active' : '' }}">
                            <i class="fas fa-notes-medical nav-icon"></i>
                            <p>Rekam Medis Pasien</p>
                        </a>
                    </li>

                    {{-- 💊 Laporan Penggunaan Obat --}}
                    <li class="nav-item">
                        <a href="{{ route('laporan_obat') }}"
                            class="nav-link {{ request()->routeIs('laporan_obat') ? 'active' : '' }}">
                            <i class="fas fa-file-medical nav-icon"></i>
                            <p>Laporan Penggunaan Obat</p>
                        </a>
                    </li>

                    {{-- 👤 Profil --}}
                    <li class="nav-item has-treeview {{ request()->routeIs('profile.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <p>
                                Profil
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                    <i class="fas fa-user nav-icon"></i>
                                    <p>Edit Profil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif




                {{-- Tambahkan kondisi untuk role lain seperti dokter, paramedis, dll di bawah ini --}}
                {{-- Contoh: --}}
                {{-- @if (Auth::check() && Auth::user()->role === 'dokter') --}}
                {{-- ...menu dokter... --}}
                {{-- @endif --}}

            </ul>
        </nav>

    </div>
    <!-- /.sidebar -->
</aside>
