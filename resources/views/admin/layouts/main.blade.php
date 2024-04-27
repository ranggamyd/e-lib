<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    @stack('meta')

    <title>E-Library | {{ $title }}</title>

    <!-- Fav Icon -->
    <link rel="shortcut icon" href="/dist/img/umc.png" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="/plugins/magnific-popup/magnificPopup.css">
    <!-- Custom -->
    <link rel="stylesheet" href="/dist/css/style.css">

    @stack('styles')
</head>

<body class="hold-transition layout-fixed layout-navbar-fixed sidebar-mini-md">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.layouts.navbar')
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">E-Library | {{ $title }}</h1>
                        </div>
                        <div class="col-sm-6">
                            @stack('breadcrumbs')
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @yield('page')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('admin.layouts.footer')

    </div>
    <!-- ./wrapper -->

    @stack('modals')

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Magnific Popup -->
    <script src="/plugins/magnific-popup/magnificPopup.js"></script>
    <!-- Tooltips -->
    <script>
        $(document).ready(function() {
            $('.img-popup').magnificPopup({
                type: 'image'
            });
            $('.has-tooltip').tooltip()
        });
    </script>
    @stack('scripts')
</body>

</html>
