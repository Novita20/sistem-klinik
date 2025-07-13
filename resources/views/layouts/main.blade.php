<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik PLN NP Paiton {{ isset($title) ? ' | ' . $title : '' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.inc.ext-css')
    @stack('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        {{-- @section('navbar')
            @include('layouts.inc.navbar')
        @show --}}
        @include('layouts.inc.navbar')

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @if (!isset($hideSidebar) || !$hideSidebar)
            @include('layouts.inc.sidebar ')
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content-header')
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>

        <!-- /.content-wrapper -->

        @include('layouts.inc.footer')


    </div>
    <!-- ./wrapper -->

    @include('layouts.inc.ext-js')
    @yield('scripts')
</body>


</html>
