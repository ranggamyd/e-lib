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
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengajuan</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Semua Pengajuan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="orders" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Pustakawan</th>
                                    <th>Keterangan</th>
                                    <th style="width: 150px!important">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $order->member->name }}</td>
                                        <td class="align-middle">{{ $order->book->title }}</td>
                                        <td class="text-center align-middle">
                                            {{ date('d M Y', strtotime($order->order_date)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($order->status == 'Rejected')
                                                <span class='badge badge-danger'>Ditolak</span>
                                            @elseif ($order->status=='Pending')
                                                <span class='badge badge-primary'>Menunggu</span>
                                            @elseif ($order->status=='Accepted')
                                                <span class='badge badge-success'>Diterima</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            {{ $order->librarian->name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $order->description }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning has-tooltip"
                                                    href="/admin/transactions/orders/{{ $order->id }}"
                                                    title="Pengajuan {{ strtok($order->member->name, ' ') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-success d-flex flex-row align-items-center has-tooltip updt_modal_btn"
                                                    order_id="{{ $order->id }}"
                                                    acceptable="{{ $order->status == 'Pending' ? true : false }}"
                                                    data-toggle="modal" data-target="#update"
                                                    title="Terima / perbarui pengajuan">
                                                    <i class="fas fa-edit mr-1"></i> Update
                                                </button>
                                            </div>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                                class="btn btn-sm btn-danger p-0">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah anda yakin?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Pustakawan</th>
                                    <th>Keterangan</th>
                                    <th style="width: 150px!important">Aksi</th>
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
        var orders = $("#orders").DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-7'f><'col-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": [
                "excel",
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 6]
                    }
                },
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [5, 6],
                visible: false
            }],
            "drawCallback": function(settings) {
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
            }
        });

        $("#members").DataTable({
            dom: "<'row'<'col-5'l><'col-7'f><'col-12 text-center'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: '',
                sLengthMenu: "Show _MENU_",
                searchPlaceholder: "Search .."
            },
            "responsive": true,
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
                targets: [2, 3],
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
