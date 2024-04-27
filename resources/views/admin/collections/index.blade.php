@extends('admin.layouts.main')

@prepend('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Koleksi</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button type="button" data-toggle="modal" data-target="#create"
                    class="btn btn-primary mt-0 mb-4 d-flex align-items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Koleksi
                </button>
            </div>
        </div>
        <div class="row">
            @foreach ($collections as $collection)
                <div class="col-md-6">
                    <div class="callout callout-{{ $colors[array_rand($colors)] }}">
                        <div class="row">
                            @if ($collection->image)
                                <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                                    <a href="/admin/collections/{{ $collection->id }}">
                                        <img src="/dist/img/collections/{{ $collection->image }}"
                                            class="img-fluid img-thumbnail rounded" alt="{{ $collection->name }}"
                                            style="height: 75px; object-fit: cover">
                                    </a>
                                </div>
                            @else
                                <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                                    <a href="/admin/collections/{{ $collection->id }}">
                                        <img src="https://via.placeholder.com/75x75.png/{{ substr(uniqid(), -3) }}?text={{ urlencode(strtok($collection->name, ' ')) }}"
                                            class="img-fluid img-thumbnail rounded" alt="{{ $collection->name }}"
                                            style="height: 75px; object-fit: cover">
                                    </a>
                                </div>
                            @endif
                            <div class="col d-flex align-items-center">
                                <a href="/admin/collections/{{ $collection->id }}" class="text-decoration-none">
                                    <h5 class="mb-0">{{ $collection->name }}</h5>
                                    <p class="text-muted mt-2">Total {{ $collection->books->count() }} Buku</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            @endforeach
        </div>
        {{-- <a href="/collections"
            class="text-decoration-none text-center d-block w-100 text-muted h5 mt-md-3 mb-md-5">Tampilkan Semua</a> --}}
        <div class="d-flex justify-content-center">{{ $collections->links() }}</div>
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
                        Tambah Koleksi
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/collections" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name" class="form-label">Nama Koleksi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Masukkan Nama Koleksi .."
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    aria-describedby="name" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image" class="form-label">Gambar Koleksi</label>
                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror" onchange="previewImg()">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <img class="img-preview img-fluid mt-3 col-sm-5">
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
    @error('image')
        <script>
            $('#create').modal('show')
        </script>
    @enderror
@endprepend
