<nav class="main-header navbar navbar-expand {{ isset($hideSidebar) && $hideSidebar ? 'ml-0' : 'ml-64' }} shadow-sm"
    style="background: linear-gradient(to right, #145da0, #0c2d48); border-bottom: 1px solid #0c2d48;">
    <!-- Left navbar links -->
    <ul class="navbar-nav pl-4">
        @if (!isset($hideSidebar) || !$hideSidebar)
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        @endif
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link font-weight-bold text-white text-lg tracking-wide" href="#">KLINIK</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto pr-4" style="align-items: center;">

        {{-- Jika Login sebagai Paramedis, tampilkan notifikasi --}}
        @auth
            @if (Auth::user()->role === 'paramedis')
                <!-- 🔔 Notifikasi Paramedis -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white position-relative" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        @php
                            $totalNotif = ($lowStockObat->count() ?? 0) + ($expiringObat->count() ?? 0);
                        @endphp
                        @if ($totalNotif > 0)
                            <span class="badge badge-danger navbar-badge">{{ $totalNotif }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ $totalNotif }} Notifikasi Paramedis</span>
                        <div class="dropdown-divider"></div>

                        {{-- Stok Menipis --}}
                        @if ($lowStockObat->count() > 0)
                            <span class="dropdown-item text-bold text-danger">⚠️ Stok Menipis</span>
                            @foreach ($lowStockObat as $obat)
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-capsules mr-2 text-danger"></i>
                                    {{ $obat->nama_obat }} - sisa {{ $obat->stok }}
                                </a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                        @endif

                        {{-- Hampir Kadaluarsa --}}
                        @if ($expiringObat->count() > 0)
                            <span class="dropdown-item text-bold text-warning">⏰ Kadaluarsa Hampir Tiba</span>
                            @foreach ($expiringObat as $obat)
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-exclamation-triangle mr-2 text-warning"></i>
                                    {{ $obat->nama_obat }} - exp
                                    {{ \Carbon\Carbon::parse($obat->expired_at)->format('d-m-Y') }}
                                </a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                        @endif

                        @if ($totalNotif === 0)
                            <a class="dropdown-item text-center text-muted">Tidak ada notifikasi</a>
                        @endif
                    </div>
                </li>
            @endif

            <!-- User Profile (semua role) -->
            <li class="nav-item d-flex align-items-center ml-3">
                <a href="{{ route('profile.edit') }}" class="d-flex align-items-center text-white"
                    style="text-decoration: none;">
                    <img src="{{ Auth::user()->profile_picture
                        ? asset('assets/dist/img/' . Auth::user()->profile_picture)
                        : asset('assets/dist/img/pp.jpg') }}"
                        alt="User" class="img-circle"
                        style="width: 36px; height: 36px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
                    <span class="font-weight-medium">{{ Auth::user()->name }}</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item ml-3">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light text-danger font-weight-bold">Logout</button>
                </form>
            </li>
        @endauth

        {{-- Jika belum login (hanya guest), tampilkan tombol Daftar & Masuk --}}
        @guest
            <li class="nav-item ml-3">
                <a href="{{ route('register') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-1 rounded transition duration-150 ease-in-out">
                    Daftar
                </a>
            </li>
            <li class="nav-item ml-3">
                <a href="{{ route('login') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-1 rounded transition duration-150 ease-in-out">
                    Masuk
                </a>
            </li>
        @endguest
    </ul>
</nav>
