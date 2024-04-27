<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="/dist/img/umc.png" alt="UMC Logo" class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text font-weight-light ml-2">E-Library UMC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/dist/img/avatar/{{ auth()->user()->avatar }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/admin/profile" class="d-block">{{ auth()->user()->username }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/admin"
                        class="nav-link {{ Request::is('admin') || Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">Main Features</li>
                <li class="nav-item {{ Request::is('admin/transactions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/transactions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Transaksi
                            <i class="fas fa-angle-right right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/transactions/orders"
                                class="nav-link {{ Request::is('admin/transactions/orders*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-up"></i>
                                <p>Pengajuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/transactions/loans"
                                class="nav-link {{ Request::is('admin/transactions/loans*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/transactions/returns"
                                class="nav-link {{ Request::is('admin/transactions/returns*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-left"></i>
                                <p>Pengembalian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/transactions/waqfs"
                                class="nav-link {{ Request::is('admin/transactions/waqfs*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-down"></i>
                                <p>Pewakafan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item {{ Request::is('admin/books*') || Request::is('admin/collections*') || Request::is('admin/categories*') || Request::is('admin/authors*') || Request::is('admin/publishers*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('admin/books*') || Request::is('admin/collections*') || Request::is('admin/categories*') || Request::is('admin/authors*') || Request::is('admin/publishers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Data Master
                            <i class="fas fa-angle-right right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/books" class="nav-link {{ Request::is('admin/books*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Semua Buku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/collections"
                                class="nav-link {{ Request::is('admin/collections*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>Koleksi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/categories"
                                class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bookmark"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/authors"
                                class="nav-link {{ Request::is('admin/authors*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-edit"></i>
                                <p>Penulis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/publishers"
                                class="nav-link {{ Request::is('admin/publishers*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>Penerbit</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::is('admin/reports*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/reports*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-swatchbook"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-right right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
                            <a href="/admin/reports/all"
                                class="nav-link {{ Request::is('admin/reports/all*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Semua Laporan</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="/admin/reports/loans"
                                class="nav-link {{ Request::is('admin/reports/loans*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="/admin/reports/returns"
                                class="nav-link {{ Request::is('admin/reports/returns*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengembalian</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="/admin/reports/waqfs"
                                class="nav-link {{ Request::is('admin/reports/waqfs*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pewakafan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- @can('administrator') --}}
                <li class="nav-header">Members & Maintainers</li>
                    <li class="nav-item">
                        <a href="/admin/members" class="nav-link {{ Request::is('admin/members*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Anggota</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/users" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Data Admin</p>
                        </a>
                    </li>
                {{-- @endcan --}}
                <li class="nav-header">Miscellaneous</li>
                <li class="nav-item">
                    <a href="/admin/profile" class="nav-link {{ Request::is('admin/profile*') ? 'active' : '' }}">
                        <i class="fas fa-id-badge nav-icon"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/help" class="nav-link {{ Request::is('admin/help*') ? 'active' : '' }}">
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
