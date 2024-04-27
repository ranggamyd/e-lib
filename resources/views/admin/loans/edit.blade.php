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
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <form action="/admin/transactions/loans/{{ $loan->id }}" method="POST"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6 order-3 order-md-1">
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
                                                        {{ old('member_id', $member->id) == $loan->member->id ? 'selected' : '' }}>
                                                        {{ $member->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('member_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/members/create" class="btn btn-outline-primary">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6 col-md-3 order-1 order-md-2">
                                    <label for="borrow_date" class="form-label">
                                        <span class="text-danger">*</span> Tanggal Pinjam
                                    </label>
                                    <input type="date" name="borrow_date"
                                        value="{{ old('borrow_date', $loan->borrow_date) }}"
                                        placeholder="Masukkan Halaman .."
                                        class="form-control @error('borrow_date') is-invalid @enderror" id="borrow_date"
                                        aria-describedby="borrow_date" required>
                                    @error('borrow_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-6 col-md-3 order-2 order-md-3">
                                    <label for="return_date" class="form-label">
                                        <span class="text-danger">*</span> Tanggal Kembali
                                    </label>
                                    <input type="date" name="return_date"
                                        value="{{ old('return_date', $loan->return_date) }}"
                                        placeholder="Masukkan Halaman .."
                                        class="form-control @error('return_date') is-invalid @enderror has-tooltip"
                                        id="return_date" aria-describedby="return_date"
                                        title="Tanggal server: {{ date('d/m/Y') }}" required>
                                    @error('return_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3 order-2 order-md-1">
                                    <label for="status" class="form-label">
                                        <span class="text-danger">*</span> Status Pinjaman
                                    </label>
                                    <div class="custom-control custom-radio">
                                        <input
                                            class="custom-control-input custom-control-input-primary custom-control-input-outline"
                                            type="radio" id="Dipinjam" name="status" value="Dipinjam"
                                            {{ old('status', $loan->status) == 'Dipinjam' ? 'checked' : '' }}>
                                        <label for="Dipinjam" class="custom-control-label"><span
                                                class="badge badge-primary">Dipinjam</span></label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input
                                            class="custom-control-input custom-control-input-success custom-control-input-outline"
                                            type="radio" id="Dikembalikan" name="status" value="Dikembalikan"
                                            {{ old('status', $loan->status) == 'Dikembalikan' ? 'checked' : '' }}>
                                        <label for="Dikembalikan" class="custom-control-label"><span
                                                class="badge badge-success">Dikembalikan</span></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-9 order-1 order-md-2">
                                    <label for="book_id" class="form-label">
                                        <span class="text-danger">*</span> Judul Buku
                                    </label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="book_id"
                                                class="form-control select2bs4 w-100 @error('book_id') is-invalid @enderror"
                                                id="book_id" required autofocus>
                                                <option selected disabled>Pilih Buku ..</option>
                                                @if ($loan->book->stock == 0)
                                                    <option value="{{ $loan->book->id }}" selected>
                                                        {{ $loan->book->title }}
                                                    </option>
                                                @endif
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        {{ old('book_id', $book->id) == $loan->book->id ? 'selected' : '' }}>
                                                        {{ $book->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('book_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/books/create" class="btn btn-outline-primary">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/admin/transactions/loans" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/transactions/loans/{{ $loan->id }}/edit" class="btn btn-secondary">
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
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Buku ..",
        })
    </script>
    <script>
        if ($('input[type=radio][name=status]:checked').val() != 'Dikembalikan') {
            $('#return_date').attr('disabled', true)
        }

        $('input[type=radio][name=status]').change(function() {
            if (this.value == 'Dikembalikan') {
                $('#return_date').attr('disabled', false)
                $('#return_date').val("{{ date('Y-m-d') }}");
            } else {
                $('#return_date').attr('disabled', true)
                $('#return_date').val(null);
            }
        });

        $('#borrow_date').change(function(e) {
            e.preventDefault();
            var val = new Date($(this).val());
            var date = new Date();
            date.setDate(date.getDate() + 7);

            if (val > date) {
                alert('Tanggal pinjam tidak dapat lebih dari 7 hari\nmohon tentukan dengan benar!')
                $(this).val(function (e) { 
                    e.preventDefault();
                });
            }
        });
    </script>
@endprepend
