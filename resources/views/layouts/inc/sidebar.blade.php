<aside class="main-sidebar sidebar-dark-primary elevation-4"
    style="background: linear-gradient(145deg, #1c2e4a, #0d1b2a); box-shadow: 5px 5px 15px rgba(0,0,0,0.2), -5px -5px 15px rgba(0,0,0,0.2);">

    <!-- Brand Logo -->
    <a href=" " class="brand-link" style="background-color: #1c2e4a; border-bottom: 1px solid #ffffff;">
        <img src="{{ url('assets/dist/img/pln.jpeg') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"
            style="color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">PLN Nusantara
            Power</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- Optional user image here --}}
            </div>
            <div class="info">
                <a href="#" class="d-block"
                    style="color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Alih Daya</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 sidebar-fixed">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    @if (Auth::check())
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.preview') }}" class="nav-link" style="color: #ffffff;">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Preview</p>
                            </a>
                        @else
                            <a href="{{ route('vendor.preview', ['id_vendor' => Auth::user()->id_vendor]) }}"
                                class="nav-link" style="color: #ffffff;">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Preview</p>
                            </a>
                        @endif
                    @else
                        <a href="{{ url('/preview') }}" class="nav-link" style="color: #ffffff;">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Preview</p>
                        </a>
                    @endif
                </li>

                <li class="nav-item">
                    @if (Auth::check())
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.input') }}" class="nav-link" style="color: #ffffff;">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Input Data</p>
                            </a>
                        @else
                            <a href="{{ route('vendor.input', ['id_vendor' => Auth::user()->id_vendor]) }}"
                                class="nav-link" style="color: #ffffff;">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Input Data</p>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" target="_blank" class="nav-link" style="color: #ffffff;">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Input Data</p>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <!-- Jika user adalah admin, arahkan ke halaman inputVendor -->
                        <a href="{{ route('admin.indexVendor') }}" class="nav-link" style="color: #ffffff;">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>Vendor</p>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <!-- Jika user adalah admin, arahkan ke halaman inputVendor -->
                        <a href="{{ route('admin.dataJabatan') }}" class="nav-link" style="color: #ffffff;">
                            <i class="nav-icon fas fa-table"></i>
                            <p>Jabatan</p>
                        </a>
                    @endif
                </li>

                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <!-- Jika user adalah admin, arahkan ke halaman inputVendor -->
                        <a href="{{ route('admin.inputUser') }}" class="nav-link" style="color: #ffffff;">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Pengguna</p>
                        </a>
                    @endif
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
