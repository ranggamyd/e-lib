@extends('layouts.main')

@section('page')
    <div class="container">
        <div class="row my-4">
            <div class="col-md-8">
                <h3 class="text-muted mb-3">Semua Koleksi</h3>
                <div class="row">
                    @foreach ($collections as $collection)
                        <div class="col-12">
                            <div class="callout callout-{{ $colors[array_rand($colors)] }}">
                                <div class="row">
                                    @if ($collection->image)
                                        <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                                            <a href="/collections/{{ $collection->id }}">
                                                <img src="/dist/img/collections/{{ $collection->image }}"
                                                    class="img-fluid img-thumbnail rounded" alt="{{ $collection->name }}"
                                                    style="height: 75px; object-fit: cover">
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                                            <a href="/collections/{{ $collection->id }}">
                                                <img src="https://via.placeholder.com/75x75.png/{{ substr(uniqid(), -3) }}?text={{ urlencode(strtok($collection->name, ' ')) }}"
                                                    class="img-fluid img-thumbnail rounded" alt="{{ $collection->name }}"
                                                    style="height: 75px; object-fit: cover">
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col d-flex align-items-center">
                                        <a href="/collections/{{ $collection->id }}" class="text-decoration-none">
                                            <h5 class="mb-0">{{ $collection->name }}</h5>
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
