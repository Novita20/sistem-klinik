<nav class="main-header navbar navbar-expand
    {{ isset($hideSidebar) && $hideSidebar ? 'ml-0' : 'ml-64' }}">


    <!-- Left navbar links -->
    <ul class="navbar-nav">
        {{-- <!-- Menu Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li> --}}

        <!-- Dashboard Link -->
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link font-weight-bold" href="#" style="color: #1c2e4a;">KLINIK</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto" style="align-items: center;">
        @if (Auth::check())
            <!-- Notification Bell -->
            <li class="nav-item dropdown">
                @if (Auth::user()->role === 'admin')
                    <!-- Pastikan hanya admin yang melihat notifikasi -->
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">{{ $expiringContractsCount ?? 0 }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ $expiringContractsCount ?? 0 }} Notifikasi</span>
                        <div class="dropdown-divider"></div>
                        @if (isset($expiringContracts) && $expiringContracts->isNotEmpty())
                            @foreach ($expiringContracts as $contract)
                                <a href="{{ route('vendor.preview', ['id_vendor' => $contract->vendor->id_vendor]) }}"
                                    class="dropdown-item">
                                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $contract->vendor->nama_vendor }}
                                    <span class="float-right text-muted text-sm">Berakhir
                                        {{ \Carbon\Carbon::parse($contract->tgl_akhir)->diffForHumans() }}</span>
                                </a>
                            @endforeach
                        @else
                            <a class="dropdown-item">Tidak ada notifikasi</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.preview') }}" class="dropdown-item dropdown-footer">Lihat Semua
                            Notifikasi</a>
                    </div>
                @endif
            </li>
            <!-- Profile Picture and User Info -->
            <li class="nav-item d-flex align-items-center ml-3">
                <!-- Profile Picture -->
                <img src="{{ Auth::user()->role === 'admin'
                    ? (Auth::user()->profile_picture
                        ? asset('assets/dist/img/' . Auth::user()->profile_picture)
                        : asset('assets/dist/img/admin.png'))
                    : (Auth::user()->profile_picture
                        ? asset('assets/dist/img/' . Auth::user()->profile_picture)
                        : asset('assets/dist/img/pp.jpg')) }}"
                    class="img-circle" alt="User Image"
                    style="width: 35px; height: 35px; object-fit: cover; border-radius: 50%; margin-right: 10px;">

                <!-- User Role or Name -->
                <span>
                    {{ Auth::user()->role === 'admin' ? 'Admin' : Auth::user()->username }}
                </span>
            </li>

            <!-- Logout Button -->
            <li class="nav-item ml-3">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </li>
        @else
            <li class="nav-item">
                <a href="#" class="d-block"
                    style="color: #000000; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Guest</a>
            </li>
        @endif
    </ul>
</nav>
