@extends('admin.layouts.main')

@prepend('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/categories">Kategori</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <a href="/admin/categories" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
            <div class="col-8 text-right">
                <button type="button" data-toggle="modal" data-target="#edit" class="btn btn-success mt-0 mb-4">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Kategori
                </button>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" data-toggle="modal" data-target="#destroy" class="btn btn-danger mt-0 mb-4"
                        onclick="return confirm('Apakah anda yakin?')">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Kategori
                    </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-text-width"></i>
                                    Tentang Kategori
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center mb-3 mb-md-0">
                                        <img src="https://via.placeholder.com/150x100.png/{{ substr(uniqid(), -3) }}?text={{ urlencode(strtok($category->name, ' ')) }}"
                                            alt="{{ $category->name }}" class="img-fluid"
                                            style="height:100px; object-fit: cover">
                                    </div>
                                    <div class="col-md-4 pt-md-3">
                                        <dl class="row">
                                            <dt class="col-sm-4">Nama Kategori</dt>
                                            <dd class="col-sm-8">{{ $category->name }}</dd>
                                            <dt class="col-sm-4">Total Buku</dt>
                                            <dd class="col-sm-8">{{ $category->books->count() }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4 pt-md-3">
                                        <dl class="row">
                                            <dt class="col-sm-4">Created at</dt>
                                            <dd class="col-sm-8">
                                                {{ date('d-m-Y, H:i', strtotime($category->created_at)) }}</dd>
                                            <dt class="col-sm-4">Updated at</dt>
                                            <dd class="col-sm-8">
                                                {{ date('d-m-Y, H:i', strtotime($category->updated_at)) }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        @if (count($category->books) != 0)
                            <h4 class="mt-4 mb-3">Semua buku dalam Kategori {{ $category->name }}</h4>
                            @foreach ($booksInCategories as $book)
                                <div class="callout callout-{{ $colors[array_rand($colors)] }}">
                                    <div class="row">
                                        @if ($book->image)
                                            <div class="col-12 col-md-4 col-lg-1 text-center mb-3 mb-md-0">
                                                <a href="/books/{{ $book->id }}">
                                                    <img src="/dist/img/books/{{ $book->image }}"
                                                        class="img-fluid img-thumbnail rounded" alt="{{ $book->title }}"
                                                        style="height: 120px; object-fit: cover">
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-12 col-md-4 col-lg-2 text-center mb-3 mb-md-0">
                                                <a href="/books/{{ $book->id }}">
                                                    <img src="https://via.placeholder.com/75x75.png/fff?text={{ urlencode(strtok($book->title, ' ')) }}"
                                                        class="img-fluid img-thumbnail rounded" alt="{{ $book->title }}"
                                                        style="height: 175px; object-fit: cover">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="col">
                                            <a href="/books/{{ $book->id }}" class="text-decoration-none">
                                                <h5 class="mb-0 mt-2">{{ $book->title }}</h5>
                                            </a>
                                            <p style="display: -webkit-box;
                                                                                                    -webkit-line-clamp: 2;
                                                                                                    -webkit-box-orient: vertical;
                                                                                                    overflow: hidden;
                                                                                                    text-overflow: ellipsis;"
                                                class="text-muted mt-3">
                                                {{ strip_tags($book->summary) }}
                                            </p>
                                            <small> in :
                                                @foreach ($book->book_categories as $bc)
                                                    <a href="/admin/categories/{{ $bc->category->id }}"
                                                        class="text-decoration-none text-primary">{{ $bc->category->name }}</a>@if (!$loop->last), @endif
                                                @endforeach
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            @endforeach
                            {{-- <a href="/books"
                                class="text-decoration-none text-center d-block w-100 text-muted h5 mt-md-3 mb-md-5">Tampilkan Semua</a> --}}
                            <div class="d-flex justify-content-center">{{ $booksInCategories->links() }}</div>
                        @endif
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

@prepend('modals')
    <div class="modal fade" id="edit">
        <div class="modal-dialog edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title d-flex justify-content-start align-items-center">
                        <i class="fas fa-plus-circle mr-2 text-muted"></i>
                        Edit Kategori
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/categories/{{ $category->id }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name" class="form-label">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                    placeholder="Masukkan Nama Kategori .."
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
@endprepend
