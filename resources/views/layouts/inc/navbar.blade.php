<nav class="main-header navbar navbar-expand {{ isset($hideSidebar) && $hideSidebar ? 'ml-0' : 'ml-64' }} shadow-sm"
    style="background: linear-gradient(to right, #145da0, #0c2d48); border-bottom: 1px solid #0c2d48;">

    <!-- Left navbar links -->
    <ul class="navbar-nav pl-4">
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link font-weight-bold text-white text-lg tracking-wide" href="#">
                KLINIK
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto pr-4" style="align-items: center;">
        @if (Auth::check())
            @if (Auth::user()->role === 'admin')
                <!-- Notification Bell -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white position-relative" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        @if (($expiringContractsCount ?? 0) > 0)
                            <span class="badge badge-warning navbar-badge">{{ $expiringContractsCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ $expiringContractsCount ?? 0 }} Notifikasi</span>
                        <div class="dropdown-divider"></div>
                        @if (!empty($expiringContracts) && $expiringContracts->isNotEmpty())
                            @foreach ($expiringContracts as $contract)
                                <a href="{{ route('vendor.preview', ['id_vendor' => $contract->vendor->id_vendor]) }}"
                                    class="dropdown-item">
                                    <i class="fas fa-exclamation-circle mr-2 text-warning"></i>
                                    {{ $contract->vendor->nama_vendor }}
                                    <span class="float-right text-muted text-sm">
                                        Berakhir {{ \Carbon\Carbon::parse($contract->tgl_akhir)->diffForHumans() }}
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <a class="dropdown-item text-center text-muted">Tidak ada notifikasi</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.preview') }}" class="dropdown-item dropdown-footer">Lihat Semua
                            Notifikasi</a>
                    </div>
                </li>
            @endif

            <!-- User Profile -->
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
        @else
            <!-- Belum Login -->
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


        @endif
    </ul>
</nav>
