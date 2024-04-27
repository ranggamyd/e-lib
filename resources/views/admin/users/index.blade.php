@extends('admin.layouts.main')

@prepend('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        @can('administrator')
            <div class="row">
                <div class="col-12">
                    <form action="/admin/users" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-primary card-outline card-widget collapsed-card">
                            <div class="card-header" data-card-widget="collapse">
                                <h3 class="card-title">Tambah Admin</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="name" class="form-label">
                                            <span class="text-danger">*</span> Nama Lengkap
                                        </label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Masukkan Nama Lengkap .."
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            aria-describedby="name" required autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="role" class="form-label">
                                            <span class="text-danger">*</span> Role
                                        </label>
                                        <select name="role"
                                            class="form-control select2bs4 w-100 @error('role') is-invalid @enderror" id="role"
                                            required>
                                            <option selected disabled>Pilih Role ..</option>
                                            <option value="staff">Staff</option>
                                            <option value="administrator">Administrator</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username" class="form-label">
                                            <span class="text-danger">*</span> Username
                                        </label>
                                        <input type="text" name="username" value="{{ old('username') }}"
                                            placeholder="Masukkan Username .."
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            aria-describedby="username" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5 offset-md-1">
                                        <label for="email" class="form-label">
                                            Alamat Email
                                        </label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="Masukkan Alamat Email .."
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            aria-describedby="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="avatar" class="form-label">Avatar</label>
                                        <input type="file" name="avatar" id="avatar"
                                            class="form-control-file @error('avatar') is-invalid @enderror"
                                            onchange="previewImg()">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <img class="img-preview img-fluid mt-3 col-sm-5">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="birth_place" class="form-label">
                                            Tempat Lahir
                                        </label>
                                        <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                                            placeholder="Tempat Lahir .."
                                            class="form-control @error('birth_place') is-invalid @enderror" id="birth_place"
                                            aria-describedby="birth_place">
                                        @error('birth_place')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="birth_date" class="form-label">
                                            Tanggal Lahir
                                        </label>
                                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                            placeholder="Masukkan Tanggal Lahir .."
                                            class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                                            aria-describedby="birth_date">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5 offset-md-1">
                                        <label for="gender" class="form-label">
                                            Jenis Kelamin
                                        </label>
                                        <select name="gender"
                                            class="form-control select2bs4 w-100 @error('gender') is-invalid @enderror"
                                            id="gender">
                                            <option selected disabled>Pilih Jenis Kelamin ..</option>
                                            <option value="Male">Laki-laki</option>
                                            <option value="Female">Perempuan</option>
                                            <option value="Others">Lainnya</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="address" class="form-label">
                                            Alamat/Domisili
                                        </label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                            id="address" placeholder="Masukkan Alamat .." cols="30"
                                            rows="3">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/admin/users" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary svbtn">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <div class="float-right">
                                    <a href="/admin/users/create" class="btn btn-success has-tooltip"
                                        title="Tambah di halaman baru">
                                        Halaman Baru <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </form>
                </div>
                <!--/.col (left) -->
            </div>
        @endcan
        <!-- /.row -->
        <div class="row">
            <div class="col">
                <div class="card card-warning card-outline card-widget">
                    <div class="card-header">
                        <h3 class="card-title">Semua Admin</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool maximize" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="users" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Avatar</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th @can('administrator') style="width: 150px!important" @endcan>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $user->name }}</td>
                                        <td class="align-middle">{{ $user->birth }}</td>
                                        <td class="align-middle">
                                            @if ($user->gender == 'Male')
                                                Laki-laki
                                            @elseif ($user->gender == 'Female')
                                                Perempuan
                                            @else
                                                Tidak diketahui
                                            @endif
                                        </td>
                                        <td class="align-middle">{!! $user->address !!}</td>
                                        <td class="text-center align-middle">
                                            <img src="/dist/img/avatar/{{ $user->avatar }}"
                                                alt="Avatar {{ strtok($user->name, ' ') }}"
                                                style="width: 100px; height: 100px; object-fit: cover">
                                        </td>
                                        <td class="align-middle">{{ $user->username }}</td>
                                        <td class="align-middle">{{ $user->email }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-warning has-tooltip"
                                                    href="{{ route('users.show', $user->id) }}"
                                                    title="Admin {{ strtok($user->name, ' ') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('administrator')
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                </div>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="btn btn-sm btn-danger p-0">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah anda yakin?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        var users = $("#users").DataTable({
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
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                "print",
                {
                    extend: 'colvis',
                    text: "Tampilkan"
                }
            ],
            'columnDefs': [{
                targets: [5, 6, 7],
                visible: false
            }],
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
    <!-- Select2 -->
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
    <script>
        function previewImg() {
            const img = document.querySelector('#avatar')
            const imgPreview = document.querySelector('.img-preview')

            imgPreview.style.display = 'block'

            const oFReader = new FileReader()
            oFReader.readAsDataURL(img.files[0])

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
    </script>
    <script>
        function ucwords(str, force) {
            str = force ? str.toLowerCase() : str;
            return str.replace(/(\b)([a-zA-Z])/g,
                function(firstLetter) {
                    return firstLetter.toUpperCase();
                });
        }

        $('#name, #birth_place, #address').keyup(function(evt) {
            var cp_value = ucwords($(this).val(), true);
            $(this).val(cp_value);
        });

        $('#birth_place').change(function(e) {
            e.preventDefault();
            $('#birth_date').attr('required', true);
        });
        $('#birth_date').change(function(e) {
            e.preventDefault();
            $('#birth_place').attr('required', true);
        });
    </script>
    @if($errors->any())
        <script>
            $('.collapsed-card').removeClass('collapsed-card');
        </script>
    @endif
@endprepend
