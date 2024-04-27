@extends('admin.layouts.main')

@prepend('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Penulis</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button type="button" data-toggle="modal" data-target="#create"
                    class="btn btn-primary mt-0 mb-4 d-flex align-items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Penulis
                </button>
            </div>
        </div>
        <div class="row">
            @foreach ($authors as $author)
                <div class="col-md-6">
                    <div class="callout callout-{{ $colors[array_rand($colors)] }}">
                        <div class="row">
                            <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                                <a href="/admin/authors/{{ $author->id }}">
                                    <img src="https://via.placeholder.com/75x75.png/{{ substr(uniqid(), -3) }}?text={{ urlencode(strtok($author->name, ' ')) }}"
                                        class="img-fluid img-thumbnail rounded" alt="{{ $author->name }}"
                                        style="height: 75px; object-fit: cover">
                                </a>
                            </div>
                            <div class="col d-flex align-items-center">
                                <a href="/admin/authors/{{ $author->id }}" class="text-decoration-none">
                                    <h5 class="mb-0">{{ $author->name }}</h5>
                                    <p class="text-muted mt-2">Total {{ $author->books->count() }} Buku</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            @endforeach
        </div>
        {{-- <a href="/authors"
            class="text-decoration-none text-center d-block w-100 text-muted h5 mt-md-3 mb-md-5">Tampilkan Semua</a> --}}
        <div class="d-flex justify-content-center">{{ $authors->links() }}</div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@prepend('modals')
    <div class="modal fade" id="create">
        <div class="modal-dialog create">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title d-flex justify-content-start align-items-center">
                        <i class="fas fa-plus-circle mr-2 text-muted"></i>
                        Tambah Penulis
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/authors" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name" class="form-label">Nama Penulis <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Masukkan Nama Penulis .."
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    aria-describedby="name" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endprepend

@prepend('scripts')
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
    @if (session()->has('create'))
        <script>
            $('#create').modal('show')
        </script>
    @endif
@endprepend
