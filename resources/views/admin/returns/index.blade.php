@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengembalian</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Semua Pengembalian</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="returns" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tenggat Pengembalian</th>
                                    <th>Status</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
                                    <th>Pustakawan</th>
                                    <th style="width: 150px!important">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returns as $return)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $return->member->name }}</td>
                                        <td class="align-middle">{{ $return->book->title }}</td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($return->borrow_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($return->due_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($return->status == 'Dipinjam')
                                                <span class='badge badge-primary'>Dipinjam</span>
                                            @elseif ($return->status == 'Dikembalikan')
                                                <span class='badge badge-success'>Dikembalikan</span>
                                            @endif
                                            @if ($return->return_date > $return->due_date)
                                                <span class='badge badge-danger'>Terlambat</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($return->return_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($return->charges != 0)
                                                {{ $return->charges }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $return->librarian->name }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning has-tooltip"
                                                    href="{{ route('returns.show', $return->id) }}"
                                                    title="Pinjaman {{ strtok($return->member->name, ' ') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                {{-- <button type="button"
                                                    class="btn btn-sm btn-success has-tooltip updt_modal_btn"
                                                    return_id="{{ $return->id }}"
                                                    returnable="{{ $return->status == 'Dipinjam' ? true : false }}"
                                                    data-toggle="modal" data-target="#update" title="Perbarui pinjaman">
                                                    <i class="fas fa-edit"></i> Update
                                                </button> --}}
                                            </div>
                                            {{-- <form action="{{ route('returns.destroy', $return->id) }}" method="POST"
                                                class="btn btn-sm btn-danger p-0">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah anda yakin?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> --}}
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
                                    <th>Tenggat Pengembalian</th>
                                    <th>Status</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
                                    <th>Pustakawan</th>
                                    <th style="width: 150px!important">Actions</th>
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

@prepend('modals')
    <div class="modal fade" id="update">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="modal-title text-center mb-3">Pilih Opsi ?</h4>
                    <div class="d-flex justify-content-center">
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
        var returns = $("#returns").DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-7'f><'col-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": [
                "excel",
                "pdf",
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [8],
                visible: false
            }],
            "drawCallback": function(settings) {
                $('.updt_modal_btn').click(function(e) {
                    e.preventDefault();
                    var return_id = $(this).attr('return_id');

                    $('.updt_btn').attr('href', '/admin/transactions/returns/' + return_id + '/edit');
                });
            }
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
