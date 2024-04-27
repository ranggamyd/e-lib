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
        <li class="breadcrumb-item active">Peminjaman</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="/admin/transactions/loans" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-primary card-outline card-widget collapsed-card">
                        <div class="card-header" data-card-widget="collapse">
                            <h3 class="card-title">Tambah Pinjaman</h3>
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
                                                @foreach ($create_loan_members as $member)
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
                                                            @foreach ($create_loan_books as $book)
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
                            <a href="/admin/transactions/loans" class="btn btn-secondary">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-primary svbtn">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <div class="float-right">
                                <a href="/admin/transactions/loans/create" class="btn btn-success has-tooltip"
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
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
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
                                    <th style="width: 60px!important">Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tenggat Pengembalian</th>
                                    <th>Status</th>
                                    <th>Pustakawan</th>
                                    <th style="width: 150px!important">Actions</th>
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
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning has-tooltip"
                                                    href="{{ route('loans.show', $loan->id) }}"
                                                    title="Pinjaman {{ strtok($loan->member->name, ' ') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-success has-tooltip updt_modal_btn"
                                                    loan_id="{{ $loan->id }}"
                                                    returnable="{{ $loan->status == 'Dipinjam' ? true : false }}"
                                                    data-toggle="modal" data-target="#update"
                                                    title="Kembalikan / perbarui pinjaman">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>
                                            </div>
                                            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST"
                                                class="btn btn-sm btn-danger p-0">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Pinjaman akan dihapus\nPastikan pinjaman sudah dikembalikan, Apakah anda yakin?')">
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
                                    <th style="width: 60px!important">Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tenggat Pengembalian</th>
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
                        <a href="" class="btn btn-info rtrn_btn mr-2">
                            <i class="fas fa-exchange-alt mr-2"></i> Sudah Kembali
                        </a>
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
        var loans = $("#loans").DataTable({
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
                targets: [6],
                visible: false
            }],
            "drawCallback": function(settings) {
                $('.updt_modal_btn').click(function(e) {
                    e.preventDefault();
                    var loan_id = $(this).attr('loan_id');
                    var returnable = $(this).attr('returnable');

                    if (returnable) {
                        $('.rtrn_btn').removeClass('disabled');
                        $('.rtrn_btn').attr('disabled', false);
                        $('.rtrn_btn').attr('href', '/admin/transactions/loans/return/' + loan_id);
                    } else {
                        // $('.rtrn_btn').remove();
                        $('.rtrn_btn').addClass('disabled');
                        $('.rtrn_btn').attr('disabled', true);
                    }
                    $('.updt_btn').attr('href', '/admin/transactions/loans/' + loan_id + '/edit');
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
    <!-- Select2 -->
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <!-- Form Repeater -->
    <script src="/plugins/jquery.repeater/jquery.repeater.min.js"></script>
    <script>
        var repeater = $('.repeater').repeater({
            ready: function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    placeholder: "Pilih Buku ..",
                })
            },
            show: function() {
                $("#books").each((i, el) => {
                    $(this).find('#books option[value="${$(el).val()}"]').remove()
                });
                $(this).slideDown();
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    placeholder: "Pilih Buku ..",
                })
            },
            hide: function(deleteElement) {
                if (confirm('Apakah anda yakin?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

        var borrowedBooks = {!! json_encode(old('borrowed_books')) !!};
        if (borrowedBooks) {
            var books = [];
            borrowedBooks.forEach(booklists => {
                books.push(booklists);
            });
            repeater.setList(books);
        }

        $('#borrow_date').change(function(e) {
            e.preventDefault();
            var val = new Date($(this).val());
            var date = new Date();
            date.setDate(date.getDate() + 7);

            if (val > date) {
                alert('Tanggal pinjam tidak dapat lebih dari 7 hari\nmohon tentukan dengan benar!')
                $(this).val('');
            }
        });
    </script>
    @if ($errors->any())
        <script>
            $('.collapsed-card').removeClass('collapsed-card');
        </script>
    @endif
@endprepend
