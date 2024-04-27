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
        <li class="breadcrumb-item active">Pewakafan</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-12">
                <form action="/admin/transactions/waqfs" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-primary card-outline card-widget collapsed-card">
                        <div class="card-header" data-card-widget="collapse">
                            <h3 class="card-title">Tambah Wakaf</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-row justify-content-between">
                                <div class="form-group col-md-6">
                                    <label for="member_id" class="form-label">
                                        <span class="text-danger">*</span> Anggota
                                    </label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="member_id"
                                                class="form-control select2bs4 w-100 @error('member_id') is-invalid @enderror"
                                                id="member_id" required autofocus>
                                                <option selected disabled>Pilih Anggota ..</option>
                                                @foreach ($create_waqf_members as $member)
                                                    @if (old('member_id') == $member->id)
                                                        <option value="{{ $member->id }}" selected>
                                                            {{ $member->name }}</option>
                                                    @else
                                                        <option value="{{ $member->id }}">
                                                            {{ $member->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('member_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2">
                                            <a href="/admin/members/create" class="btn btn-outline-primary">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="borrow_date" class="form-label">
                                        <span class="text-danger">*</span> Tanggal Pinjam
                                    </label>
                                    <input type="date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}"
                                        placeholder="Masukkan Halaman .."
                                        class="form-control @error('borrow_date') is-invalid @enderror has-tooltip"
                                        id="borrow_date" aria-describedby="borrow_date"
                                        title="Tanggal server: {{ date('d/m/Y') }}" required>
                                    @error('borrow_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <div class="repeater">
                                        <div data-repeater-list="borrowed_books">
                                            <label for="books" class="form-label">
                                                <span class="text-danger">*</span> Buku yang tersedia
                                            </label>
                                            <div data-repeater-item>
                                                <div class="row mb-3">
                                                    <div class="col-10">
                                                        <select name="books"
                                                            class="form-control select2bs4 w-100 @error('borrowed_books') is-invalid @enderror"
                                                            id="books" required>
                                                            <option selected disabled>Pilih Buku ..</option>
                                                            @foreach ($create_waqf_books as $book)
                                                                <option value="{{ $book->id }}">
                                                                    {{ $book->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('borrowed_books')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-2 text-right">
                                                        <button type="button" data-repeater-delete
                                                            class="btn btn-outline-danger">
                                                            <i class="fas fa-backspace"></i>
                                                            <span class="d-none d-md-inline ml-2">Hapus</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-repeater-create class="btn btn-outline-primary">
                                            <i class="fas fa-plus-circle mr-2"></i> Tambah Pilihan
                                        </button>
                                    </div>
                                    @error('borrowed_books')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/admin/transactions/waqfs" class="btn btn-secondary">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-primary svbtn">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <div class="float-right">
                                <a href="/admin/transactions/waqfs/create" class="btn btn-success has-tooltip"
                                    title="Tambah di halaman baru">
                                    Halaman Baru <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </form>
            </div>
            <!--/.col (left) -->
        </div> --}}
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Semua Pewakafan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="waqfs" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
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
                                        <th style="width: 150px!important">Actions</th>
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
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning has-tooltip"
                                                    href="/admin/transactions/waqfs/{{ $waqf->id }}"
                                                    title="Wakaf {{ strtok($waqf->member->name, ' ') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-success d-flex flex-row align-items-center has-tooltip updt_modal_btn"
                                                    waqf_id="{{ $waqf->id }}"
                                                    acceptable="{{ $waqf->status == 'Tertunda' ? true : false }}"
                                                    data-toggle="modal" data-target="#update"
                                                    title="Terima / perbarui wakaf">
                                                    <i class="fas fa-edit mr-1"></i> Update
                                                </button>
                                            </div>
                                            <form action="{{ route('waqfs.destroy', $waqf->id) }}" method="POST"
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
                                        <th>Tanggal Wakaf</th>
                                        <th>Judul Buku</th>
                                        <th>Jumlah Halaman</th>
                                        <th>Abstrak</th>
                                        <th>File</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>Status</th>
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
                    <a href="" class="btn btn-info accpt_btn mr-2">
                        <i class="fas fa-check mr-2"></i> Konfirmasi
                    </a>
                    <a href="" class="btn btn-danger rjct_btn mr-2">
                        <i class="fas fa-times mr-2"></i> Tolak Wakaf
                    </a>
                    <a href="" class="btn btn-success updt_btn">
                        <i class="fas fa-edit mr-2"></i> Perbarui Pewakafan
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
        var waqfs = $("#waqfs").DataTable({
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
            }],
            "drawCallback": function(settings) {
                $('.updt_modal_btn').click(function(e) {
                    e.preventDefault();
                    var waqf_id = $(this).attr('waqf_id'); console.log(waqf_id);
                    var acceptable = $(this).attr('acceptable');

                    if (acceptable) {
                        $('.accpt_btn').removeClass('disabled');
                        $('.accpt_btn').attr('disabled', false);
                        $('.accpt_btn').attr('href', '/admin/transactions/waqfs/accept/' + waqf_id);
                        $('.rjct_btn').removeClass('disabled');
                        $('.rjct_btn').attr('disabled', false);
                        $('.rjct_btn').attr('href', '/admin/transactions/waqfs/reject/' + waqf_id);
                    } else {
                        // $('.accpt_btn').remove();
                        $('.accpt_btn').addClass('disabled');
                        $('.accpt_btn').attr('disabled', true);
                        // $('.rjct_btn').remove();
                        $('.rjct_btn').addClass('disabled');
                        $('.rjct_btn').attr('disabled', true);
                    }
                    $('.updt_btn').attr('href', '/admin/transactions/waqfs/' + waqf_id + '/edit');
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
    
    @if ($errors->any())
        <script>
            $('.collapsed-card').removeClass('collapsed-card');
        </script>
    @endif
@endprepend
