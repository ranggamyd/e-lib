@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Buku</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="/admin/books/create" class="btn btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Buku
                </a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="books" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th data-priority="1">Judul Buku</th>
                                    <th>ISBN</th>
                                    <th>Koleksi</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Editor</th>
                                    <th>Stok</th>
                                    <th>Lokasi</th>
                                    <th>Halaman</th>
                                    <th>Pewakaf</th>
                                    <th data-priority="2" style="width: 110px!important">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle"
                                            style="display: -webkit-box;
                                        -webkit-line-clamp: 3;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                        text-overflow: ellipsis;">
                                            {{ $book->title }}</td>
                                        <td class="text-center align-middle">{{ $book->isbn }}</td>
                                        <td class="align-middle">{{ $book->collection->name }}</td>
                                        <td class="text-center align-middle">
                                            @foreach ($book->book_categories as $category)
                                                <a href="/admin/categories/{{ $category->category->id }}"
                                                    class="badge badge-pill badge-{{ $colors[array_rand($colors)] }}">{{ $category->category->name }}</a>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">
                                            @foreach ($book->book_authors as $author)
                                                <a href="/admin/authors/{{ $author->author->id }}"
                                                    class="badge badge-success">{{ $author->author->name }}</a>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">{{ $book->publisher->name }}</td>
                                        <td class="text-center align-middle">{{ $book->publish_year }}</td>
                                        <td class="align-middle">{{ $book->librarian->name }}</td>
                                        <td class="text-center align-middle">{{ $book->stock }}</td>
                                        <td class="align-middle">{{ $book->shelf }}</td>
                                        <td class="text-center align-middle">{{ $book->page_count }}</td>
                                        <td class="align-middle">{{ $book->waqf_id ? $book->waqf->member->name : '-' }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('books.show', $book->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('books.edit', $book->id) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                    class="btn btn-sm btn-danger p-0">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah anda yakin?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th data-priority="1">Judul Buku</th>
                                    <th>ISBN</th>
                                    <th>Koleksi</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Editor</th>
                                    <th>Stok</th>
                                    <th>Lokasi</th>
                                    <th>Halaman</th>
                                    <th>Pewakaf</th>
                                    <th data-priority="2" style="width: 110px!important">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@prepend('scripts')
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/jszip/jszip.min.js"></script>
    <script src="/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Page specific script -->
    <script>
        $("#books").DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-7'f><'col-12'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "autoWidth": false,
            "buttons": [
                "excel",
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 5, 6, 7, 9, 10, 11, 12]
                    }
                },
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [2, 5, 6, 7, 8, 11, 12],
                visible: false
            }]
        });
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
@endprepend
