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

<body class="hold-transition sidebar-collapse layout-fixed layout-navbar-fixed layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @if (!Request::is('transactions*') && !Request::is('profile*'))
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container">
                        <div class="container col-xxl-8 px-4 py-2">
                            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                                <div class="col-10 col-sm-8 col-lg-6">
                                    <img src="/dist/img/photo1.png" class="d-block mx-lg-auto img-fluid"
                                        alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                                </div>
                                <div class="col-lg-6">
                                    <h1 class="mb-3">Selamat Datang di E-Library UMC</h1>
                                    <p class="lead">Tempat yang tepat bagi mahasiswa, dosen, dan staff untuk
                                        menjelajahi dunia pengetahuan dengan mudah dan cepat. Kajian koleksi e-book,
                                        jurnal, tesis, dan sumber daya akademik lainnya yang kaya dan bervariasi untuk
                                        mendukung kebutuhan belajar, mengajar, dan penelitian Anda.</p>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                        @if (auth()->user())
                                            <a href="/admin/dashboard" class="btn btn-primary btn-lg px-4 mr-md-2"><i
                                                    class="fas fa-sign-in-alt mr-2"></i>Dashboard</a>
                                        @elseif(auth()->guard('members')->user())
                                            <a href="/profile" class="btn btn-primary btn-lg px-4 mr-md-2"><i
                                                    class="fas fa-sign-in-alt mr-2"></i>Profil saya</a>
                                        @else
                                            <a href="/login" class="btn btn-primary btn-lg px-4 mr-md-2"><i
                                                    class="fas fa-sign-in-alt mr-2"></i>Login</a>
                                        @endif
                                        <a href="/books" class="btn btn-outline-secondary btn-lg px-4">Lihat
                                            sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
            @endif

            <!-- Main content -->
            <section class="content {{ !Request::is('transactions*') && !Request::is('profile*') ? '' : 'pt-4' }}">
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
