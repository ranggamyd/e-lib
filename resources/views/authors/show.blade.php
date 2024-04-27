@extends('layouts.main')

@section('page')
    <div class="container">
        <div class="row my-4">
            <div class="col-md-8">
                <h3 class="text-muted mb-3">Buku yang ditulis oleh {{ $author->name }}</h3>
                <div class="row">
                    @foreach ($booksInAuthors as $book)
                        <div class="col-12">
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
                                                    style="height: 150px; object-fit: cover">
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
                                            {!! $book->summary !!}
                                        </p>
                                        <small> in :
                                            @foreach ($book->book_categories as $category)
                                                <a href="/categories/{{ $category->category->id }}"
                                                    class="text-decoration-none text-primary">{{ $category->category->category }}</a>@if (!$loop->last), @endif
                                            @endforeach
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    @endforeach
                </div>
                {{-- <a href="/books"
                    class="text-decoration-none text-center d-block w-100 text-muted h5 mt-md-3 mb-md-5">Tampilkan Semua</a> --}}
                <div class="d-flex justify-content-center">{{ $booksInAuthors->links() }}</div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="row mb-4">
                    <div class="col">
                        <h3 class="text-muted mb-3">New Collections</h3>
                        <div class="card card-outline card-primary">
                            <div class="card-body" style="display: block;">
                                <div class="list-group list-group-flush">
                                    @foreach ($newCollections as $item)
                                        <a href="/collections/{{ $item->id }}"
                                            class="list-group-item list-group-item-action">{{ $item->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <h3 class="text-muted mb-3">Popular Tags</h3>
                        <div class="card card-outline card-danger">
                            <div class="card-body" style="display: block;">
                                <div class="list-group list-group-flush">
                                    @foreach ($popTags->take(5) as $item)
                                        <a href="/categories/{{ $item->category_id }}"
                                            class="list-group-item list-group-item-action">{{ $item->category->category }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
