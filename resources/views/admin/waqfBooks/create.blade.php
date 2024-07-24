@extends('admin.layouts.main')

@prepend('styles')
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/waqfBooks">Buku Wakaf</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
                <!-- jquery validation -->
                <div class="card">
                    <!-- form start -->
                    <form action="/admin/books" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="title" class="form-label"><span class="text-danger">*</span> Judul
                                        Buku</label>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        placeholder="Masukkan Judul Buku .."
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        aria-describedby="title" required autofocus>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="collection_id" class="form-label"><span class="text-danger">*</span>
                                        Koleksi</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="collection_id"
                                                class="form-control select2bs4 w-100 @error('collection_id') is-invalid @enderror"
                                                id="collection_id" required>
                                                <option selected disabled>Pilih Koleksi ..</option>
                                                @foreach ($collections as $collection)
                                                    <option value="{{ $collection->id }}"
                                                        {{ old('collection_id') == $collection->id ? 'selected' : '' }}>
                                                        {{ $collection->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('collection_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/collections/create" class="btn btn-outline-primary" target="__blank">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="book_categories[]" class="form-label"><span
                                            class="text-danger">*</span> Kategori</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="book_categories[]"
                                                class="form-control select2bs4 w-100 @error('book_categories') is-invalid @enderror"
                                                id="book_categories[]" multiple="multiple"
                                                data-placeholder="Pilih Kategori Buku .." required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ (old('book_categories') == null ? '' : in_array($category->id, old('book_categories'))) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('book_categories')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/categories/create" class="btn btn-outline-primary" target="__blank">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image" class="form-label">Gambar Sampul</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control-file @error('image') is-invalid @enderror"
                                        onchange="previewImg()">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <img class="img-preview img-fluid mt-3 col-sm-5">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="book_pdf" class="form-label">File PDF</label>
                                    <input type="file" name="book_pdf" id="book_pdf"
                                        class="form-control-file @error('book_pdf') is-invalid @enderror">
                                    @error('book_pdf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="summary" class="form-label">Ringkasan</label>
                                    <textarea name="summary"
                                        class="form-control @error('summary') is-invalid @enderror mb-0" id="summary"
                                        aria-describedby="summary">{{ old('summary') }}</textarea>
                                    @error('summary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 ml-md-4">
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="stock" class="form-label">Stok</label>
                                            <input type="number" name="stock" value="{{ old('stock', 1) }}"
                                                placeholder="Jumlah Buku .." min="1"
                                                class="form-control @error('stock') is-invalid @enderror" id="stock"
                                                aria-describedby="stock" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="shelf" class="form-label">Lokasi Buku</label>
                                            <input type="text" name="shelf" value="{{ old('shelf') }}"
                                                placeholder="Rak 2 - Web Programming"
                                                class="form-control @error('shelf') is-invalid @enderror" id="shelf"
                                                aria-describedby="shelf" required>
                                            @error('shelf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="book_authors[]" class="form-label">Penulis</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="book_authors[]"
                                                class="form-control select2bs4 w-100 @error('book_authors') is-invalid @enderror"
                                                id="book_authors[]" multiple="multiple" data-placeholder="Pilih Penulis ..">
                                                @foreach ($authors as $author)
                                                    <option value="{{ $author->id }}"
                                                        {{ (old('book_authors') == null ? '' : in_array($author->id, old('book_authors'))) ? 'selected' : '' }}>
                                                        {{ $author->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('book_authors')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/authors/create" class="btn btn-outline-primary" target="__blank">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="publisher_id" class="form-label">Penerbit</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="publisher_id"
                                                class="form-control select2bs4 w-100 @error('publisher_id') is-invalid @enderror"
                                                id="publisher_id">
                                                <option selected disabled>Pilih Penerbit ..</option>
                                                @foreach ($publishers as $publisher)
                                                    <option value="{{ $publisher->id }}"
                                                        {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                                                        {{ $publisher->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('publisher_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/publishers/create" class="btn btn-outline-primary" target="__blank">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="number" name="isbn" value="{{ old('isbn') }}"
                                        placeholder="Nomor ISBN .." class="form-control @error('isbn') is-invalid @enderror"
                                        id="isbn" aria-describedby="isbn">
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3 col-6">
                                    <label for="publish_year" class="form-label">Tahun Terbit</label>
                                    <input type="number" name="publish_year" value="{{ old('publish_year') }}"
                                        placeholder="Tahun Buku Diterbitkan .."
                                        class="form-control @error('publish_year') is-invalid @enderror" id="publish_year"
                                        aria-describedby="publish_year">
                                    @error('publish_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3 col-6">
                                    <label for="page_count" class="form-label">Total Halaman</label>
                                    <input type="number" name="page_count" value="{{ old('page_count') }}"
                                        placeholder="Jumlah Halaman .."
                                        class="form-control @error('page_count') is-invalid @enderror" id="page_count"
                                        aria-describedby="page_count">
                                    @error('page_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/admin/books" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/books/create" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary">
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
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#summary').summernote({
            height: 70,
            placeholder: 'Tuliskan Isi Ringkasan ..',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
    <script>
        function previewImg() {
            const img = document.querySelector('#image')
            const imgPreview = document.querySelector('.img-preview')

            imgPreview.style.display = 'block'

            const oFReader = new FileReader()
            oFReader.readAsDataURL(img.files[0])

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
    </script>
@endprepend
