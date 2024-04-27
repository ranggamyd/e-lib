@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Search</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        @if ($loans)
        <div class="row">
            <div class="col-md-8">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Semua Pinjaman</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="loans" class="table table-bordered table-striped">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
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
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
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
                                            @elseif ($status=='Dikembalikan')
                                                <span class='badge badge-success'>Dikembalikan</span>
                                                @if ($isLate == true)
                                                    <span class='badge badge-danger'>Terlambat</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime('+1 month', strtotime($loan->borrow_date))) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($loan->return_date)
                                                {{ date('d M Y', strtotime($loan->return_date)) }}
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
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card card-danger card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Mahasiswa Terkait</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="members" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>NPM</th>
                                    <th>Prodi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $member->name }}</td>
                                        <td class="text-center align-middle">{{ $member->npm }}</td>
                                        <td class="align-middle">{{ $member->subject->name }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning has-tooltip"
                                                    href="{{ route('loans.show', $member->id) }}"
                                                    title="Pinjaman {{ strtok($member->name, ' ') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @cannot('manager')
                                                    <a class="btn btn-sm btn-danger has-tooltip"
                                                        href="/admin/transactions/loans/destroyByMember/{{ $member->id }}"
                                                        title="Hapus semua pinjaman milik {{ $member->name }}"
                                                        onclick="return confirm('Semua pinjaman milik {{ $member->name }} akan dihapus, Apakah anda yakin?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endcannot
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>NPM</th>
                                    <th>Prodi</th>
                                    <th>Actions</th>
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
        @endif
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
        var loans = $("#loans").DataTable({
            dom: "<'row mx-1'<'col-md-5'l><'col-md-7'f><'col-12'>B>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": [
                "excel",
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5, 6]
                    }
                },
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [3, 5, 6],
                visible: false
            }]
        });
    </script>
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
@endprepend
