@extends('layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endprepend

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="/dist/img/avatar/{{ $member->avatar }}"
                                alt="User profile picture">
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

                        <a href="/admin/member/{{ $member->id }}" class="btn btn-primary btn-block"><b>Profil</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tentang {{ strtok($member->name, ' ') }}</h3>
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
                    <div class="card-body">
                        <strong><i class="far fa-id-badge mr-1"></i> Nomor Induk Mahasiswa</strong>
                        <p class="text-muted">{{ $member->npm }}</p>
                        <hr>
                        <strong><i class="fas fa-university mr-1"></i> Program Studi</strong>
                        <p class="text-muted">{{ $member->subject->name }}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted">{{ $member->address }}</p>
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
                            <li class="nav-item"><a class="nav-link active" href="#loans" data-toggle="tab">Sudah Dikembalikan</a></li>
                            {{-- <li class="nav-item"><a class="nav-link" href="#borrowed"
                                    data-toggle="tab">Dipinjam</a></li>
                            <li class="nav-item"><a class="nav-link" href="#returned"
                                    data-toggle="tab">Dikembalikan</a></li> --}}
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="loans">
                                <table id="t_returns" class="table table-bordered table-striped">
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
                                                    @if ($return->return_date < $return->due_date)
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
        $("#t_returns").DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-7'f><'col-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": [
                "excel",
                {
                    extend: 'pdf',
                    customize: function(doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                },
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [1, 8],
                visible: false
            }],
        });
    </script>
@endprepend
