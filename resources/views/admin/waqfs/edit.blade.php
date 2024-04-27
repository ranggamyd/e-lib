@extends('admin.layouts.main')

@prepend('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
@endprepend

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/transactions/waqfs">Pewakafan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <form action="/admin/transactions/waqfs/{{ $waqf->id }}" method="POST"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2 d-flex align-items-center waqf-2 waqf-md-1">
                                        <div class="form-group">
                                            <label for="status" class="form-label">
                                                <span class="text-danger">*</span> Status Pinjaman
                                            </label>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-primary custom-control-input-outline"
                                                    type="radio" id="Tertunda" name="status" value="Tertunda"
                                                    {{ old('status', $waqf->status) == 'Tertunda' ? 'checked' : '' }}>
                                                <label for="Tertunda" class="custom-control-label"><span
                                                        class="badge badge-primary">Tertunda</span></label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-success custom-control-input-outline"
                                                    type="radio" id="Dikonfirmasi" name="status" value="Dikonfirmasi"
                                                    {{ old('status', $waqf->status) == 'Dikonfirmasi' ? 'checked' : '' }}>
                                                <label for="Dikonfirmasi" class="custom-control-label"><span
                                                        class="badge badge-success">Diterima</span></label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                    type="radio" id="Ditolak" name="status" value="Ditolak"
                                                    {{ old('status', $waqf->status) == 'Ditolak' ? 'checked' : '' }}>
                                                <label for="Ditolak" class="custom-control-label"><span
                                                        class="badge badge-danger">Ditolak</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10 order-1 order-md-2">
                                        <div class="form-row justify-content-between">
                                            <div class="form-group col-md-6">
                                                <label for="member_id" class="form-label">
                                                    <span class="text-danger">*</span> Anggota
                                                </label>
                                                <select name="member_id"
                                                    class="form-control disabled select2bs4 w-100 @error('member_id') is-invalid @enderror"
                                                    id="member_id" required readonly>
                                                    {{-- <option selected disabled>Pilih Anggota ..</option> --}}
                                                    @foreach ($members as $member)
                                                        @if ($member->id == $waqf->member_id)
                                                            <option value="{{ $member->id }}"
                                                                {{ $member->id == $waqf->member_id ? 'selected' : '' }}>
                                                                {{ $member->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('member_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="waqf_date" class="form-label">
                                                    <span class="text-danger">*</span> Tanggal Wakaf
                                                </label>
                                                <input type="date" name="waqf_date"
                                                    value="{{ old('waqf_date', $waqf->waqf_date) }}"
                                                    placeholder="Masukkan Tanggal Wakaf .."
                                                    class="form-control @error('waqf_date') is-invalid @enderror has-tooltip"
                                                    id="waqf_date" aria-describedby="waqf_date"
                                                    title="Tanggal server: {{ date('d/m/Y') }}" required>
                                                @error('waqf_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="title" class="form-label"><span class="text-danger">*</span>
                                                    Judul
                                                    Buku</label>
                                                <input type="text" name="title" value="{{ old('title', $waqf->title) }}"
                                                    placeholder="Masukkan Judul Buku .."
                                                    class="form-control @error('title') is-invalid @enderror" id="title"
                                                    aria-describedby="title" required autofocus>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="soft_file" class="form-label"><span
                                                        class="text-danger">*</span> Soft File (PDF)</label>
                                                <input type="file" name="soft_file" id="soft_file"
                                                    class="form-control-file @error('soft_file') is-invalid @enderror"
                                                    >
                                                @error('soft_file')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="abstract" class="form-label"><span class="text-danger">*</span>
                                                Abstrak</label>
                                            <textarea name="abstract" class="form-control @error('abstract') is-invalid @enderror mb-0" id="abstract"
                                                aria-describedby="abstract" required>{{ old('abstract', $waqf->abstract) }}</textarea>
                                            @error('abstract')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="page_count" class="form-label"><span
                                                        class="text-danger">*</span> Total Halaman</label>
                                                <input type="number" name="page_count" value="{{ old('page_count', $waqf->page_count) }}"
                                                    placeholder="Jumlah Halaman .."
                                                    class="form-control @error('page_count') is-invalid @enderror"
                                                    id="page_count" aria-describedby="page_count" required>
                                                @error('page_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="payment_slip" class="form-label"><span
                                                        class="text-danger">*</span> Bukti Pembayaran</label>
                                                <input type="file" name="payment_slip" id="payment_slip"
                                                    class="form-control-file @error('payment_slip') is-invalid @enderror"
                                                    onchange="previewImg()">
                                                @error('payment_slip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <img class="img-preview img-fluid mt-3 col-sm-5">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row descInput">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="description" class="form-label text-danger">Keterangan</label>
                                            <input type="text" name="description"
                                                value="{{ old('description', $waqf->description) }}"
                                                placeholder="Masukkan Keterangan .."
                                                class="form-control @error('description') is-invalid @enderror"
                                                id="description" aria-describedby="description">
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/admin/transactions/waqfs" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/transactions/waqfs/{{ $waqf->id }}/edit" class="btn btn-secondary">
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
    <!-- Form Repeater -->
    <script src="/plugins/jquery.repeater/jquery.repeater.min.js"></script>
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Anggota ..",
        })
        $('#abstract').summernote({
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
        function previewImg() {
            const img = document.querySelector('#payment_slip')
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
        if ($('input[type=radio][name=status]:checked').val() == 'Ditolak') {
            $('.descInput').show(400);
        } else {
            $('.descInput').hide(400);
        }

        $('input[type=radio][name=status]').change(function() {
            if (this.value == 'Ditolak') {
                $('.descInput').show(400);
                $('#description').val('{{ $waqf->description }}');
            } else {
                $('.descInput').hide(400);
                $('#description').val(null);
            }
        });
    </script>
@endprepend
