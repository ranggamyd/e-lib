@extends('admin.layouts.main')

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/books">Buku</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-widget">
                    <div class="card-header">
                        <div class="user-block">
                            <img class="img-circle" src="/dist/img/avatar/{{ $book->librarian->avatar }}" alt="librarian">
                            <span class="username">
                                <a href="/admin/users/{{ $book->librarian->id }}">
                                    {{ $book->librarian->name }}
                                </a>
                            </span>
                            <span class="description">{{ $book->created_at->diffForHumans() }}</span>
                        </div>
                        <!-- /.user-block -->
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8 order-2 order-md-1">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="text-muted"><i class="fas fa-file-alt mr-2"></i> {{ $book->title }}
                                        </h1>
                                        <p class="text-muted mt-2">
                                            @if ($book->book_authors) By @foreach ($book->book_authors as $author)
                                                    <a href="/admin/authors/{{ $author->author->id }}"
                                                        class="text-decoration-none">
                                                        {{ $author->author->name }}
                                                    </a>@if (!$loop->last), @endif
                                                @endforeach @endif
                                            @if ($book->publish_year) &middot {{ $book->publish_year }}@endif
                                        </p>
                                        @if ($book->book_pdf)
                                            <a href="/dist/pdf/{{ $book->book_pdf }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye mr-1"></i> Preview
                                            </a>
                                            <a href="/dist/pdf/{{ $book->book_pdf }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-file-pdf mr-1"></i> Download PDF
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-4 order-1">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Telah Dipinjam
                                                    Sebanyak</span>
                                                <span
                                                    class="info-box-number text-center text-muted mb-0">{{ $booksInLoans->count() }}X</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 order-3 order-md-2">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Status</span>
                                                <span class="info-box-number text-center text-muted mb-0">
                                                    @if ($book->stock > 0)
                                                        <span class="badge badge-success">{{ $book->stock }}
                                                            Tersisa</span>
                                                    @else
                                                        <span class="badge badge-danger">Stok Habis</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 order-2 order-md-3">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Total Halaman</span>
                                                <span
                                                    class="info-box-number text-center text-muted mb-0">{{ $book->page_count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-text-width"></i>
                                                    Tentang Buku
                                                </h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <dl class="row mb-0 order-1">
                                                            <dt class="col-sm-4">Title</dt>
                                                            <dd class="col-sm-8">{{ $book->title }}</dd>
                                                            <dt class="col-sm-4">ISBN</dt>
                                                            <dd class="col-sm-8">{{ $book->isbn }}</dd>
                                                            <dt class="col-sm-4">Published</dt>
                                                            <dd class="col-sm-8">{{ $book->publish_year }}</dd>
                                                            <dt class="col-sm-4">Publisher</dt>
                                                            <dd class="col-sm-8">
                                                                <a href="/admin/publishers/{{ $book->publisher->id }}">
                                                                    {{ $book->publisher->name }}
                                                                </a>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-md-6 order-3 order-md-2">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-4">librarian</dt>
                                                            <dd class="col-sm-8"><a
                                                                    href="/admin/users/{{ $book->librarian->id }}">{{ $book->librarian->name }}</a>
                                                            </dd>
                                                            <dt class="col-sm-4">Page Count</dt>
                                                            <dd class="col-sm-8">{{ $book->page_count }}</dd>
                                                            <dt class="col-sm-4">Categories</dt>
                                                            <dd class="col-sm-8">
                                                                @foreach ($book->book_categories as $category)
                                                                    <a href="/categories/{{ $category->category->id }}"
                                                                        class="text-decoration-none">{{ $category->category->category }}</a>@if (!$loop->last), @endif
                                                                @endforeach
                                                            </dd>
                                                            <dt class="col-sm-4">Tersedia</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $book->stock }}
                                                            </dd>
                                                            <dt class="col-sm-4">Pewakaf</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $book->waqf_id ? $book->waqf->member->name : '-' }}
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-12 order-2 order-md-3">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-2">Authors</dt>
                                                            <dd class="col-sm-10">
                                                                @foreach ($book->book_authors as $author)
                                                                    <a href="/admin/authors/{{ $author->author->id }}"
                                                                        class="text-decoration-none">{{ $author->author->name }}</a>@if (!$loop->last), @endif
                                                                @endforeach
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <h4>Ringkasan</h4>
                                        <div class="post">
                                            <p class="text-muted">{!! $book->summary !!}</p>
                                            <span class="text-muted">Source : Publisher</span>
                                        </div>

                                        {{-- <h4>Dapatkan Buku</h4>
                                        <div class="post clearfix mt-2">
                                            <div class="row">
                                                <div class="col-6 text-center">
                                                    <h6>Lihat / Download PDF</h6>
                                                    <a href="/dist/pdf/{{ $book->book_pdf }}"
                                                        class="btn btn-sm btn-outline-primary my-2 {{ !$book->book_pdf ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        {{ !$book->book_pdf ? 'Unavailable' : 'Preview' }}
                                                    </a><br>
                                                    <a href="/dist/pdf/{{ $book->book_pdf }}"
                                                        class="btn btn-sm btn-outline-danger {{ !$book->book_pdf ? 'disabled' : '' }}">
                                                        <i class="fas fa-file-pdf mr-2"></i>
                                                        {{ !$book->book_pdf ? 'Unavailable' : 'Download PDF' }}
                                                    </a>
                                                </div>
                                                <div class="col-6 col-md-4 text-center">
                                                    <h6 class="mb-0">Temukan di Perpustakaan UMC</h6>
                                                    @if ($book->shelf)
                                                        <p class="text-muted mb-2">
                                                            <i>Lokasi Buku:</i><br>
                                                            {{ $book->shelf }}
                                                        </p>
                                                        @auth('members')
                                                            <form action="/transactions/orders" method="post">
                                                                @csrf
                                                                <input type="hidden" name="book_id" value="{{ $book->id }}" required>
                                                                <button type="submit" onclick="return confirm('Apakah anda yakin ingin mengajukan pinjaman?')"
                                                                    class="btn btn-block btn-sm btn-outline-primary d-flex justify-content-around align-items-center {{ $book->stock <= 0 ? 'disabled' : '' }}">
                                                                    {{ $book->stock <= 0 ? 'Unavailable' : 'Ajukan Pinjaman' }}
                                                                    <i class="fas fa-angle-double-right ml-1"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="/login"
                                                                class="btn btn-sm btn-outline-primary d-flex justify-content-around align-items-center {{ $book->stock <= 0 ? 'disabled' : '' }}">
                                                                {{ $book->stock <= 0 ? 'Unavailable' : 'Ajukan Pinjaman' }}
                                                                <i class="fas fa-angle-double-right ml-1"></i>
                                                            </a>
                                                        @endauth
                                                    @else
                                                        <p class="text-muted mt-4">Mohon Maaf!<br> Buku tidak tersedia</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 order-1 order-md-2">
                                <img class="img-fluid rounded img-thumbnail mb-3"
                                    src="{{ $book->image ? '/dist/img/books/' . $book->image : 'https://via.placeholder.com/450x600.png/fff?text=' . urlencode('Buku ' . strtok($book->title, ' ') . ' :)') }}"
                                    alt="{{ $book->title }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection
