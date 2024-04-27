@extends('admin.layouts.main')

@prepend('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/members">Anggota</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <form action="/admin/members/{{ $member->id }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name" class="form-label">
                                        <span class="text-danger">*</span> Nama Lengkap
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $member->name) }}"
                                        placeholder="Masukkan Nama Lengkap .."
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        aria-describedby="name" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="npm" class="form-label">
                                        <span class="text-danger">*</span> NIM/NPM
                                    </label>
                                    <input type="number" name="npm" value="{{ old('npm', $member->npm) }}"
                                        placeholder="Masukkan NIM/NPM .."
                                        class="form-control @error('npm') is-invalid @enderror" id="npm"
                                        aria-describedby="npm" required>
                                    @error('npm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="subject_id" class="form-label">
                                        <span class="text-danger">*</span> Prodi
                                    </label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="subject_id"
                                                class="form-control select2bs4 w-100 @error('subject_id') is-invalid @enderror"
                                                id="subject_id">
                                                <option selected disabled>Pilih Prodi ..</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        {{ old('subject_id', $member->subject_id) == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subject_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center">
                                            <a href="/admin/subjects/create" class="btn btn-outline-primary">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-5 offset-md-1">
                                    <label for="email" class="form-label">
                                        Alamat Email
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', $member->email) }}"
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
                                    @if ($member->avatar)
                                        <img src="/dist/img/avatar/{{ $member->avatar }}"
                                            class="img-preview img-fluid mt-3 col-sm-5">
                                    @else
                                        <img class="img-preview img-fluid mt-3 col-sm-5">
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                {{-- <div class="form-group col-md-2">
                                    <label for="birth_place" class="form-label">
                                        Tempat Lahir
                                    </label>
                                    <input type="text" name="birth_place"
                                        value="{{ old('birth_place') }}"
                                        placeholder="Tempat Lahir .."
                                        class="form-control @error('birth_place') is-invalid @enderror" id="birth_place"
                                        aria-describedby="birth_place">
                                    @error('birth_place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label for="birth_date" class="form-label">
                                        Tanggal Lahir
                                    </label>
                                    <input type="date" name="birth_date"
                                        value="{{ $member->birth ? old('birth_date', date('Y-m-d', strtotime($member->birth))) : '' }}"
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
                                        <option value="Male"
                                            {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                        <option value="Others"
                                            {{ old('gender', $member->gender) == 'Others' ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
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
                                        id="address" placeholder="Masukkan Alamat .."
                                        rows="3">{{ old('address', $member->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/admin/members" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/members/create" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary svbtn">
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
@endprepend
