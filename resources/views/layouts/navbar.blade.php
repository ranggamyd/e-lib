<nav class="main-header navbar navbar-expand-md layout-fixed navbar-light navbar-white">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="/dist/img/umc.png" alt="UMC Logo" class="brand-image img-circle elevation-1" style="opacity: .75">
            <span class="brand-text font-weight-light"><b>E-Library UMC</b></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="/contact" class="nav-link">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        class="nav-link dropdown-toggle">FAQs</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">Some action </a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>

                        <li class="dropdown-divider"></li>

                        <!-- Level two dropdown-->
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                </li>

                                <!-- Level three dropdown-->
                                <li class="dropdown-submenu">
                                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        class="dropdown-item dropdown-toggle">level 2</a>
                                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                    </ul>
                                </li>
                                <!-- End Level three -->

                                <li><a href="#" class="dropdown-item">level 2</a></li>
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li> --}}
            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            @if (auth()->user())
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
                            <img src="/dist/img/avatar/{{ auth()->user()->avatar }}" class="img-circle"
                                alt="User Image">

                            <p>
                                {{ auth()->user()->name }}
                                <small class="text-capitalize my-2">{{ auth()->user()->role }} - Perpustakaan
                                    UMC</small>
                                {{-- <small>{{ auth()->user()->birth }}</small> --}}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="float-left">
                                <a href="/admin/profile" class="btn btn-default">Profile</a>
                            </div>
                            <div class="float-right">
                                <a href="/logout" class="btn btn-default">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            @elseif(auth()->guard('members')->user())
                <!-- User Account Menu -->
                <li class="nav-item dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="nav-link drop dropdown-toggle" data-toggle="dropdown">
                        <i class="far fa-user mr-2"></i>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span>{{ auth()->guard('members')->user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu animate slideIn">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="/dist/img/avatar/{{ auth()->guard('members')->user()->avatar }}"
                                class="img-circle" alt="User Image">

                            <p>
                                {{ auth()->guard('members')->user()->name }}
                                <small class="text-capitalize my-1">{{ auth()->guard('members')->user()->npm }} -
                                    {{ auth()->guard('members')->user()->subject->name }}</small>
                                {{-- <small>{{ auth()->user()->birth }}</small> --}}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="float-left">
                                <a href="/profile" class="btn btn-default">Profile</a>
                            </div>
                            <div class="float-right">
                                <a href="/logout" class="btn btn-default">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            @else
                <!-- User Account Menu -->
                <li class="nav-item">
                    <a href="/login" class="nav-link">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span>Login</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
