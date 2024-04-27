@extends('admin.layouts.main')

@prepend('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/transactions/orders">Pengajuan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form action="/admin/transactions/orders/{{ $order->id }}" method="POST"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center order-2 order-md-1">
                                        <div class="form-group">
                                            <label for="status" class="form-label">
                                                <span class="text-danger">*</span> Status Pinjaman
                                            </label>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-primary custom-control-input-outline"
                                                    type="radio" id="Pending" name="status" value="Pending"
                                                    {{ old('status', $order->status) == 'Pending' ? 'checked' : '' }}>
                                                <label for="Pending" class="custom-control-label"><span
                                                        class="badge badge-primary">Menunggu</span></label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-success custom-control-input-outline"
                                                    type="radio" id="Accepted" name="status" value="Accepted"
                                                    {{ old('status', $order->status) == 'Accepted' ? 'checked' : '' }}>
                                                <label for="Accepted" class="custom-control-label"><span
                                                        class="badge badge-success">Diterima</span></label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                    type="radio" id="Rejected" name="status" value="Rejected"
                                                    {{ old('status', $order->status) == 'Rejected' ? 'checked' : '' }}>
                                                <label for="Rejected" class="custom-control-label"><span
                                                        class="badge badge-danger">Ditolak</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 order-1 order-md-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
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
                                                                        {{ old('member_id', $member->id) == $order->member->id ? 'selected' : '' }}>
                                                                        {{ $member->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('member_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-2 text-right">
                                                            <a href="/admin/members/create" class="btn btn-outline-primary">
                                                                <i class="fas fa-plus-circle"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="book_id" class="form-label">
                                                    <span class="text-danger">*</span> Judul Buku
                                                </label>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <select name="book_id"
                                                            class="form-control select2bs4 w-100 @error('book_id') is-invalid @enderror"
                                                            id="book_id" required autofocus>
                                                            <option selected disabled>Pilih Buku ..</option>
                                                            @foreach ($books as $book)
                                                                <option value="{{ $book->id }}"
                                                                    {{ old('book_id', $book->id) == $order->book->id ? 'selected' : '' }}>
                                                                    {{ $book->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('book_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-2 text-right">
                                                        <a href="/admin/books/create" class="btn btn-outline-primary">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row descInput">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="description" class="form-label text-danger">Keterangan</label>
                                            <input type="text" name="description"
                                                value="{{ old('description', $order->description) }}"
                                                placeholder="Masukkan Keterangan .."
                                                class="form-control @error('description') is-invalid @enderror"
                                                id="description" aria-describedby="description">
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/admin/transactions/orders" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/transactions/orders/{{ $order->id }}/edit" class="btn btn-secondary">
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
        if ($('input[type=radio][name=status]:checked').val() == 'Rejected') {
            $('.descInput').show(400);
        } else {
            $('.descInput').hide(400);
        }

        $('input[type=radio][name=status]').change(function() {
            if (this.value == 'Rejected') {
                $('.descInput').show(400);
                $('#description').val('{{ $order->description }}');
            } else {
                $('.descInput').hide(400);
                $('#description').val(null);
            }
        });
    </script>
@endprepend
