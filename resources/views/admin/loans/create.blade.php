@extends('admin.layouts.main')

@prepend('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/transactions/loans">Peminjaman</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <form action="/admin/transactions/loans" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
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
                                                            @foreach ($books as $book)
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
                            <a href="/admin/transactions/loans" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/transactions/loans/create" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary svbtn">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@prepend('scripts')
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
