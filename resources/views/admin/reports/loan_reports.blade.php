@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Peminjaman</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Laporan Peminjaman</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        
                    <table id="reports" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th style="width: 60px!important">Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tenggat Pengembalian</th>
                                    <th>Status</th>
                                    <th>Pustakawan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $loan->member->name }}</td>
                                        <td class="align-middle">
                                            <p style="
                                                    display: -webkit-box;
                                                    -webkit-line-clamp: 5;
                                                    -webkit-box-orient: vertical;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;">
                                                {{ $loan->book->title }}
                                            </p>
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($loan->borrow_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($loan->due_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($loan->status == 'Dipinjam')
                                                <span class='badge badge-primary'>Dipinjam</span>
                                            @elseif ($loan->status == 'Dikembalikan')
                                                <span class='badge badge-success'>Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $loan->librarian->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th style="width: 60px!important">Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tenggat Pengembalian</th>
                                    <th>Status</th>
                                    <th>Pustakawan</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@prepend('scripts')
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/jszip/jszip.min.js"></script>
    <script src="/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Page specific script -->
    <script>
        var reports = $("#reports").DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-7'f><'col-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ]
        });
    </script>
@endprepend
