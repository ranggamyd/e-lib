@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/transactions/orders">Pengajuan</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="/dist/img/avatar/{{ $member->avatar }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $member->name }}</h3>

                        <p class="text-muted text-center mb-0">{{ $member->npm }}</p>
                        <p class="text-muted text-center">{{ $member->subject->name }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Buku yg dipinjam</b> <span class="float-right">{{ $loans->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Dikembalikan</b> <span
                                    class="float-right">{{ $returns->count() }}</span>
                            </li>
                        </ul>

                        <a href="/admin/members/{{ $member->id }}" class="btn btn-primary btn-block"><b>Profil</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#orders" data-toggle="tab">Semua
                                    Pengajuan</a></li>
                            {{-- <li class="nav-item"><a class="nav-link" href="#pending"
                                    data-toggle="tab">Menunggu</a></li>
                            <li class="nav-item"><a class="nav-link" href="#accepted"
                                    data-toggle="tab">Diterima</a></li>
                            <li class="nav-item"><a class="nav-link" href="#rejected"
                                    data-toggle="tab">Ditolak</a></li> --}}
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="orders">
                                <table id="t_orders" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Mahasiswa</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Pustakawan</th>
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
                                                    {{ $order->description }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ $order->librarian->name }}
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
                                            <th>Keterangan</th>
                                            <th>Pustakawan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
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
        var orders = $("#t_orders").DataTable({
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
                targets: [6],
                visible: false
            }]
        });
    </script>
@endprepend
