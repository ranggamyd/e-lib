@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Semua Laporan</h3>
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
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                    <th>Tenggat Pengembalian</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
                                    <th>Pustakawan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <?php
                                    $n_date = date_create(date('Y-m-d'));
                                    $b_date = date_create($report->borrow_date);
                                    $r_date = date_create($report->return_date);
                                    $d_date = date_create(date('Y-m-d', strtotime('+1 month', strtotime($report->borrow_date))));
                                    
                                    $status = '';
                                    $isLate = false;
                                    $fine = '';
                                    
                                    if (!$report->return_date) {
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
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $report->member->name }}</td>
                                        <td class="align-middle">{{ $report->book->title }}</td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($report->borrow_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($status == 'Dipinjam')
                                                <span class='badge badge-primary'>Dipinjam</span>
                                                @if ($isLate == true)
                                                    <span class='badge badge-danger'>Terlambat</span>
                                                @endif
                                            @elseif ($status=='Dikembalikan')
                                                <span class='badge badge-success'>Dikembalikan</span>
                                                @if ($isLate == true)
                                                    <span class='badge badge-danger'>Terlambat</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime('+1 month', strtotime($report->borrow_date))) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($report->return_date)
                                                {{ date('d M Y', strtotime($report->return_date)) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($fine != '')
                                                {{ $fine }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $report->librarian->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                    <th>Tenggat Pengembalian</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
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
