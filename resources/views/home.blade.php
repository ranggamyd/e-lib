@extends('layouts.main')

@section('page')
    <div class="container">
        <h3 class="text-muted mb-3">Koleksi Populer</h3>
        <div class="row mb-4">
            @foreach ($collections->take(3) as $collection)
                <div class="col-6 col-md-3">
                    <div class="card shadow-md" style="overflow:hidden">
                        <a href="/collections/{{ $collection->id }}" class="text-decoration-none">
                            @if ($collection->image)
                                <div class="text-white d-flex align-items-end justify-content-end"
                                    style="background: url(/dist/img/collections/{{ $collection->image }}) center center; height: 125px; background-repeat: no-repeat">
                                    <h5 class="text-right p-2 rounded-left" style="background-color: rgba(0,0,0,.25)">
                                        {{ $collection->name }}</h5>
                                </div>
                            @else
                                <div class="text-white d-flex align-items-end justify-content-end"
                                    style="background: url(https://via.placeholder.com/350x150.png/{{ substr(uniqid(), -3) }}?text={{ urlencode(strtok($collection->name, ' ')) }}) center center; height: 125px; background-repeat: no-repeat">
                                    <h5 class="text-right p-2 rounded-left" style="background-color: rgba(0,0,0,.25)">
                                        {{ $collection->name }}</h5>
                                </div>
                            @endif
                        </a>
                    </div>
                    <!-- /.widget-user -->
                </div>
                <!-- /.col -->
            @endforeach
            <div class="col-6 col-md-3">
                <div class="card shadow-md" style="overflow:hidden">
                    <button type="button" class="text-decoration-none border-0 p-0" data-toggle="modal"
                        data-target="#allCollections">
                        <div class="text-white d-flex align-items-end justify-content-end"
                            style="background: url(https://via.placeholder.com/350x150.png/fff?text={{ urlencode('Semua Koleksi') }}) center center; height: 125px; background-repeat: no-repeat">
                            <h5 class="text-right p-2 rounded-left" style="background-color: rgba(0,0,0,.25)">
                                Semua Koleksi</h5>
                        </div>
                    </button>
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row mb-4">
            <div class="col-md-8">
                <h3 class="text-muted mb-3">New Books</h3>
                <div class="row">
                    @foreach ($books as $book)
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
                                    @endif
                                    <div class="col">
                                        <a href="/books/{{ $book->id }}" class="text-decoration-none">
                                            <h5 class="">{{ $book->title }}</h5>
                                        </a>
                                        <p class="mb-1" style="display: -webkit-box;
                                                                -webkit-line-clamp: 2;
                                                                -webkit-box-orient: vertical;
                                                                overflow: hidden;
                                                                text-overflow: ellipsis;" class="text-muted">
                                            {{ strip_tags($book->summary) }}
                                        </p>
                                        <small> in :
                                            @foreach ($book->book_categories as $bc)
                                                <a href="/categories/{{ $bc->category->id }}"
                                                    class="text-decoration-none text-primary">{{ $bc->category->name }}</a>@if (!$loop->last), @endif
                                            @endforeach
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    @endforeach
                </div>
                <a href="/books"
                    class="text-decoration-none text-center d-block w-100 text-muted h5 mt-md-3 mb-md-5">Tampilkan Semua</a>
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
                                            class="list-group-item list-group-item-action">{{ $item->category->name }}</a>
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

@prepend('modals')
    <!-- Modal -->
    <div class="modal fade" id="allCollections" tabindex="-1" role="dialog" aria-labelledby="allCollectionsTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        @foreach ($collections as $collection)
                            <div class="col-6 col-md-4">
                                <div class="card shadow-md" style="border-radius: overflow:hidden">
                                    <a href="/collections/{{ $collection->id }}" class="text-decoration-none">
                                        @if ($collection->image)
                                            <div class="text-white d-flex align-items-end justify-content-end" style="
                                                                        background: url(/dist/img/collections/{{ $collection->image }}) center center;
                                                                        height: 125px; background-repeat: no-repeat">
                                                <h5 class="text-right p-2 rounded-left"
                                                    style="background-color: rgba(0,0,0,.25)">
                                                    {{ $collection->name }}</h5>
                                            </div>
                                        @else
                                            <div class="text-white d-flex align-items-end justify-content-end" style="
                                                                    background: url(https://via.placeholder.com/350x150.png/{{ substr(uniqid(), -3) }}?text={{ urlencode(strtok($collection->name, ' ')) }}) center center;
                                                                    height: 125px; background-repeat: no-repeat">
                                                <h5 class="text-right p-2 rounded-left"
                                                    style="background-color: rgba(0,0,0,.25)">
                                                    {{ $collection->name }}</h5>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <!-- /.widget -->
                            </div>
                            <!-- /.col -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endprepend
