<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/profile" class="nav-link">Profil Saya</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Account Menu -->
        <li class="nav-item dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="nav-link drop dropdown-toggle" data-toggle="dropdown">
                <i class="far fa-user mr-2"></i>
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span>{{ auth()->user()->username }}</span>
            </a>
            <ul class="dropdown-menu animate slideIn">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <img src="/dist/img/avatar/{{ auth()->user()->avatar }}" class="img-circle" alt="User Image">

                    <p>
                        {{ auth()->user()->name }}
                        <small class="text-capitalize my-2">{{ auth()->user()->role }} - Perpustakaan UMC</small>
                        {{-- <small>{{ auth()->user()->birth }}</small> --}}
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="float-left">
                        <a href="/admin/profile" class="btn btn-default">Profil</a>
                    </div>
                    <div class="float-right">
                        <a href="/logout" class="btn btn-default">Keluar</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>
