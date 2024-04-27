@extends('layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@section('page')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header p-2">
                        <a href="/transactions/waqfs/create" class="btn btn-primary"><i
                                class="fas fa-angle-double-right mr-2"></i>Wakafkan Buku</a>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="loans">
                                <table id="t_waqfs" class="table table-bwaqfed table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Mahasiswa</th>
                                            <th>Tanggal Wakaf</th>
                                            <th>Judul Buku</th>
                                            <th>Jumlah Halaman</th>
                                            <th>Abstrak</th>
                                            <th>File</th>
                                            <th>Bukti Pembayaran</th>
                                            <th>Status</th>
                                            <th>Pustakawan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($waqfs as $waqf)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $waqf->member->name }}</td>
                                                <td class="text-center align-middle">
                                                    {{ date('d M Y', strtotime($waqf->waqf_date)) }}</td>
                                                <td class="align-middle"
                                                    style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $waqf->title }}</td>
                                                <td class="text-center align-middle">{{ $waqf->page_count }}</td>
                                                <td class="align-middle"
                                                    style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                    {!! $waqf->abstract !!}</td>
                                                <td class="text-center align-middle"><a
                                                        href="/dist/pdf/{{ $waqf->soft_file }}"
                                                        class="btn-sm btn-link">Download</a></td>
                                                <td class="text-center align-middle">
                                                    <a href="/dist/img/waqfs/{{ $waqf->payment_slip }}" class="img-popup">
                                                        <img src="/dist/img/waqfs/{{ $waqf->payment_slip }}"
                                                            class="img-thumbnail" alt="{{ $waqf->member->name }}"
                                                            style="width: 100px; height: 100px; object-fit: cover">
                                                    </a>
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($waqf->status == 'Tertunda')
                                                        <span class='badge badge-primary'>Tertunda</span>
                                                    @elseif ($waqf->status == 'Dikonfirmasi')
                                                        <span class='badge badge-success'>Dikonfirmasi</span>
                                                    @elseif ($waqf->status == 'Ditolak')
                                                        <span class='badge badge-danger'>Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    {{ $waqf->librarian->name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Mahasiswa</th>
                                            <th>Tanggal Wakaf</th>
                                            <th>Judul Buku</th>
                                            <th>Jumlah Halaman</th>
                                            <th>Abstrak</th>
                                            <th>File</th>
                                            <th>Bukti Pembayaran</th>
                                            <th>Status</th>
                                            <th>Pustakawan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
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
        $("#t_waqfs").DataTable({
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
                targets: [5, 9],
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
