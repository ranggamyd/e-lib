@extends('admin.layouts.main')

@prepend('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clock"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text text-bold">Sedang dipinjam</span>
                        <span class="info-box-number">
                            {{ round($borrowedPercentage, 2) }}
                            <small>%</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text text-bold">Terlambat</span>
                        <span class="info-box-number">
                            {{ round($latePercentage, 2) }}
                            <small>%</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Buku</span>
                        <span class="info-box-number">{{ $books->count() }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Anggota</span>
                        <span class="info-box-number">{{ $cMembers->count() }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-9">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Pengajuan Terbaru</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive table-centered">
                            <table class="table m-0">
                                <thead>
                                    <tr class="text-center">
                                        <th>Mahasiswa</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->take(5) as $order)
                                        <tr>
                                            <td>{{ $order->member->name }}</td>
                                            <td>{{ $order->book->title }}</td>
                                            <td class="text-center align-middle">
                                                {{ date('d M Y', strtotime($order->created_at)) }}
                                            </td>
                                            <td class="text-center">
                                                @if ($order->status == 'Accepted')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif ($order->status == 'Rejected')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="Action Buttons">
                                                    <button type="button"
                                                        class="btn btn-sm btn-success d-flex flex-row align-items-center has-tooltip updt_modal_btn"
                                                        order_id="{{ $order->id }}"
                                                        acceptable="{{ $order->status == 'Pending' ? true : false }}"
                                                        data-toggle="modal" data-target="#update"
                                                        title="Terima / perbarui pengajuan">
                                                        <i class="fas fa-edit mr-1"></i> Update
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- <a href="/admin/order" class="btn btn-sm btn-info float-left">Place New Order</a> --}}
                        <a href="/admin/transactions/orders" class="btn btn-sm btn-info">Lihat Semua</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-3">
                <!-- PRODUCT LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Buku Terbaru</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($books->take(4) as $book)
                                <li class="item">
                                    {{-- <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                    </div> --}}
                                    <div class="ml-2">
                                        <a href="/admin/books/{{ $book->id }}"
                                            class="product-title" style="display: -webkit-box;
                                            -webkit-line-clamp: 1;
                                            -webkit-box-orient: vertical;
                                            overflow: hidden;
                                            text-overflow: ellipsis;">{{ $book->title }}</a>
                                        <span class="product-description">
                                            {{ strip_tags($book->summary) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="/admin/books" class="uppercase">Lihat Semua</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-4">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Anggota Terbaru</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">{{ $members->count() }} Anggota Aktif</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            @foreach ($members->take(8) as $member)
                                <li>
                                    <img src="/dist/img/avatar/{{ $member->avatar }}" alt="Avatar">
                                    <a class="users-list-name"
                                        href="/admin/member/{{ $member->id }}">{{ $member->name }}</a>
                                    {{-- <span class="users-list-date">Today</span> --}}
                                </li>
                            @endforeach
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="/admin/members">Lihat Semua</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!--/.card -->
            </div>
            <div class="col-md-8">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Peminjaman Terbaru</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr class="text-center">
                                        <th>Mahasiswa</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans->take(5) as $loan)
                                        <?php
                                        $n_date = date_create(date('Y-m-d'));
                                        $b_date = date_create($loan->borrow_date);
                                        $r_date = date_create($loan->return_date);
                                        $d_date = date_create(date('Y-m-d', strtotime('+1 month', strtotime($loan->borrow_date))));
                                        
                                        $status = '';
                                        $isLate = false;
                                        $fine = '';
                                        
                                        if (!$loan->return_date) {
                                            $status = 'Dipinjam';
                                            if ($n_date > $d_date) {
                                                $isLate = true;
                                                $diff = date_diff($d_date, $n_date)->format('%a');
                                                $fine = number_format($diff * 1000, 0, ',', '.');
                                            }
                                        } else {
                                            $status = 'Dikembalikan';
                                            if ($r_date > $d_date) {
                                                $isLate = true;
                                                $diff = date_diff($d_date, $r_date)->format('%a');
                                                $fine = number_format($diff * 1000, 0, ',', '.');
                                            }
                                        }
                                        ?>
                                        <tr>
                                            {{-- <td class="text-center align-middle">{{ $loop->iteration }}</td> --}}
                                            <td class="align-middle">{{ $loan->member->name }}</td>
                                            <td class="align-middle">{{ $loan->book->title }}</td>
                                            <td class="text-center align-middle">
                                                {{ date('d M Y', strtotime($loan->borrow_date)) }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($status == 'Dipinjam')
                                                    <span class='badge badge-primary'>Dipinjam</span>
                                                    @if ($isLate == true)
                                                        <span class='badge badge-danger'>Terlambat</span>
                                                    @endif
                                                @elseif ($status == 'Dikembalikan')
                                                    <span class='badge badge-success'>Dikembalikan</span>
                                                    @if ($isLate == true)
                                                        <span class='badge badge-danger'>Terlambat</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group" role="group" aria-label="Action Buttons">
                                                    <button type="button"
                                                        class="btn btn-sm btn-success has-tooltip updt_loan_modal_btn"
                                                        loan_id="{{ $loan->id }}"
                                                        returnable="{{ $loan->status == 'Dipinjam' ? true : false }}"
                                                        data-toggle="modal" data-target="#updateLoan"
                                                        title="Kembalikan / perbarui pinjaman">
                                                        <i class="fas fa-edit"></i> Update
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="/admin/transactions/loans/create" class="btn btn-sm btn-info float-left">Tambah Pinjaman</a>
                        <a href="/admin/transactions/loans" class="btn btn-sm btn-secondary float-right">Lihat Semua</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!--/. container-fluid -->
@endsection

@prepend('modals')
    <div class="modal fade" id="update">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="modal-title text-center mb-3">Pilih Opsi ?</h4>
                    <div class="d-flex justify-content-center">
                        <a href="" class="btn btn-info accpt_btn mr-2">
                            <i class="fas fa-check mr-2"></i> Terima
                        </a>
                        <a href="" class="btn btn-danger rjct_btn mr-2">
                            <i class="fas fa-times mr-2"></i> Tolak
                        </a>
                        <a href="" class="btn btn-success updt_btn">
                            <i class="fas fa-edit mr-2"></i> Perbarui Pengajuan
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="updateLoan">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="modal-title text-center mb-3">Pilih Opsi ?</h4>
                    <div class="d-flex justify-content-center">
                        <a href="" class="btn btn-info rtrn_btn mr-2">
                            <i class="fas fa-exchange-alt mr-2"></i> Sudah Kembali
                        </a>
                        <a href="" class="btn btn-success updt_btn">
                            <i class="fas fa-edit mr-2"></i> Perbarui Pinjaman
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endprepend

@prepend('scripts')
    <!-- ChartJS -->
    <script src="/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/dist/js/pages/dashboard2.js"></script>
    <!-- Toastr -->
    <script src="/plugins/toastr/toastr.min.js"></script>
    @if (session()->has('success'))
        <script>
            toastr.success("{{ session('success') }}", "Berhasil", {
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "5000",
            });
        </script>
    @endif
    <script>
        $('.updt_modal_btn').click(function(e) {
            e.preventDefault();
            var order_id = $(this).attr('order_id');
            var acceptable = $(this).attr('acceptable');

            if (acceptable) {
                $('.accpt_btn').removeClass('disabled');
                $('.accpt_btn').attr('disabled', false);
                $('.accpt_btn').attr('href', '/admin/transactions/orders/accept/' + order_id);
                $('.rjct_btn').removeClass('disabled');
                $('.rjct_btn').attr('disabled', false);
                $('.rjct_btn').attr('href', '/admin/transactions/orders/reject/' + order_id);
            } else {
                // $('.accpt_btn').remove();
                $('.accpt_btn').addClass('disabled');
                $('.accpt_btn').attr('disabled', true);
                // $('.rjct_btn').remove();
                $('.rjct_btn').addClass('disabled');
                $('.rjct_btn').attr('disabled', true);
            }
            $('.updt_btn').attr('href', '/admin/transactions/orders/' + order_id + '/edit');
        });
        $('.updt_loan_modal_btn').click(function(e) {
            e.preventDefault();
            var loan_id = $(this).attr('loan_id');
            var returnable = $(this).attr('returnable');

            if (returnable) {
                $('.rtrn_btn').removeClass('disabled');
                $('.rtrn_btn').attr('disabled', false);
                $('.rtrn_btn').attr('href', '/admin/transactions/loans/return/' + loan_id);
            } else {
                // $('.rtrn_btn').remove();
                $('.rtrn_btn').addClass('disabled');
                $('.rtrn_btn').attr('disabled', true);
            }
            $('.updt_btn').attr('href', '/admin/transactions/loans/' + loan_id + '/edit');
        });
    </script>
@endprepend
