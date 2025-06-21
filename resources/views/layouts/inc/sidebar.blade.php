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
            <div class="image">
                {{-- Optional user image here --}}
            </div>
            <div class="info">
                <a href="#" class="d-block"
                    style="color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Klinik</a>
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
                        <a href="{{ route('resep.obat') }}"
                            class="nav-link {{ request()->routeIs('resep.obat') ? 'active' : '' }}">
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
                            'rekam.medis',
                            'resep.create',
                        ]);

                        $isStokObat = in_array($routeName, [
                            'obat.index',
                            'obat.mutasi',
                            'obat.rekap',
                            'paramedis.restock.index',
                        ]);

                        $isProfil = $routeName === 'profile.edit';
                    @endphp

                    {{-- 🔷 Modul 1: Rawat Jalan --}}
                    <li class="nav-item has-treeview {{ $isRawatJalan ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isRawatJalan ? 'active' : '' }}">
                            <p>
                                Rawat Jalan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('paramedis.kunjungan.index') }}"
                                    class="nav-link pl-4 {{ $routeName === 'paramedis.kunjungan.index' ? 'active' : '' }}">
                                    <i class="fas fa-notes-medical nav-icon"></i>
                                    <p>Data Kunjungan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.kunjungan.riwayat') }}"
                                    class="nav-link pl-4 {{ $routeName === 'paramedis.kunjungan.riwayat' ? 'active' : '' }}">
                                    <i class="fas fa-history nav-icon"></i>
                                    <p>Riwayat Kunjungan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.pemeriksaan.awal') }}"
                                    class="nav-link pl-4 {{ $routeName === 'paramedis.pemeriksaan.awal' ? 'active' : '' }}">
                                    <i class="fas fa-stethoscope nav-icon"></i>
                                    <p>Pemeriksaan Awal</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rekam.medis') }}"
                                    class="nav-link pl-4 {{ $routeName === 'rekam.medis' ? 'active' : '' }}">
                                    <i class="fas fa-file-medical nav-icon"></i>
                                    <p>Rekam Medis (Lihat)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('resep.create') }}"
                                    class="nav-link pl-4 {{ $routeName === 'resep.create' ? 'active' : '' }}">
                                    <i class="fas fa-pills nav-icon"></i>
                                    <p>Input Resep Obat</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- 🔷 Modul 2: Manajemen Stok Obat --}}
                    <li class="nav-item has-treeview {{ $isStokObat ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isStokObat ? 'active' : '' }}">
                            <p>
                                Manajemen Stok Obat
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('obat.index') }}"
                                    class="nav-link pl-4 {{ $routeName === 'obat.index' ? 'active' : '' }}">
                                    <i class="fas fa-table nav-icon"></i>
                                    <p>Input Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('obat.mutasi') }}"
                                    class="nav-link pl-4 {{ $routeName === 'obat.mutasi' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-exchange-alt"></i>
                                    <p>Mutasi Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('obat.rekap') }}"
                                    class="nav-link pl-4 {{ $routeName === 'obat.rekap' ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Rekap Penggunaan Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('paramedis.restock.index') }}"
                                    class="nav-link pl-4 {{ $routeName === 'paramedis.restock.index' ? 'active' : '' }}">
                                    <i class="fas fa-truck-loading nav-icon"></i>
                                    <p>Pengajuan Restok Obat</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- 🔷 Modul 3: Profil --}}
                    <li class="nav-item has-treeview {{ $isProfil ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isProfil ? 'active' : '' }}">
                            <p>
                                Profil
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}"
                                    class="nav-link pl-4 {{ $isProfil ? 'active' : '' }}">
                                    <i class="fas fa-user nav-icon"></i>
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
                            <li class="nav-item">
                                <a href="{{ route('dokter.rekammedis.tindakan') }}"
                                    class="nav-link pl-4 {{ request()->routeIs('dokter.rekammedis.tindakan') ? 'active' : '' }}">
                                    <i class="fas fa-syringe nav-icon"></i>
                                    <p>Terapi / Tindakan</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- 💊 Resep Obat --}}
                    <li class="nav-item">
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
