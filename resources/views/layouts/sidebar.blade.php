<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="/dist/img/umc.png" alt="UMC Logo" class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text font-weight-light">Perpustakaan UMC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        @auth('members')
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/dist/img/avatar/{{ auth()->guard('members')->user()->avatar }}"
                        class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="/profile" class="d-block">{{ auth()->guard('members')->user()->username }}</a>
                </div>
            </div>
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ Request::is('/') || Request::is('/home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Homepage</p>
                    </a>
                </li>
                @auth('members')
                    <li class="nav-header">Main Features</li>
                    <li class="nav-item {{ Request::is('transactions*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Transaksi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/transactions/orders"
                                    class="nav-link {{ Request::is('transactions/orders*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-up"></i>
                                    <p>Pengajuan Saya</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/transactions/loans"
                                    class="nav-link {{ Request::is('transactions/loans*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-right"></i>
                                    <p>Buku yang dipinjam</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/transactions/returns"
                                    class="nav-link {{ Request::is('transactions/returns*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-left"></i>
                                    <p>Sudah Dikembalikan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/transactions/waqfs"
                                    class="nav-link {{ Request::is('transactions/waqfs*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-double-down"></i>
                                    <p>Pewakafan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endauth
                <li class="nav-header">Data Master</li>
                <li class="nav-item">
                    <a href="/books" class="nav-link {{ Request::is('books*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Semua Buku</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/collections" class="nav-link {{ Request::is('collections*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Koleksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/categories" class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bookmark"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/authors" class="nav-link {{ Request::is('authors*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Penulis</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/publishers" class="nav-link {{ Request::is('publishers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>Penerbit</p>
                    </a>
                </li>
                <li class="nav-header">Miscellaneous</li>
                @auth('members')
                    <li class="nav-item">
                        <a href="/profile" class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
                            <i class="fas fa-id-badge nav-icon"></i>
                            <p>Profil Saya</p>
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a href="/help" class="nav-link {{ Request::is('help*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle nav-icon"></i>
                        <p>Bantuan</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
