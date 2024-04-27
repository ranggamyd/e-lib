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
        <li class="breadcrumb-item"><a href="/admin/transactions/members">Anggota</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
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
                                <b>Buku yg dipinjam</b> <span
                                    class="float-right">{{ $loans->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Dikembalikan</b> <span
                                    class="float-right">{{ $returns->count() }}</span>
                            </li>
                        </ul>

                        <a href="/admin/members/print/{{ $member->id }}"
                            class="btn btn-primary btn-block" target="_blank"><i class="far fa-address-card mr-2"></i><b>Cetak Kartu</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Info Lengkap</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="far fa-file-alt mr-1"></i> Nama Lengkap</strong>
                        <p class="text-muted">{{ $member->name }}</p>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <strong><i class="far fa-id-badge mr-1"></i> Nomor Induk Mahasiswa</strong>
                                <p class="text-muted">{{ $member->npm }}</p>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-university mr-1"></i> Program Studi</strong>
                                <p class="text-muted">{{ $member->subject->name }}</p>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <strong><i class="fas fa-birthday-cake mr-1"></i> Tempat, Tanggal Lahir</strong>
                        <p class="text-muted">{{ $member->birth }}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted">{{ $member->address }}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
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
        $("#t_loans").DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-7'f><'col-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": [
                "excel",
                {
                    extend: ['pdf'],
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 6, 7]
                    }
                },
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [4, 7],
                visible: false
            }],
        });
    </script>
@endprepend
