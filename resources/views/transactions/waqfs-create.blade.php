@extends('layouts.main')

@prepend('styles')
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
@endprepend

@section('page')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <form action="/transactions/waqfs" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
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
                                            @if (
                                                $member->id ==
                                                    auth()->guard('members')->user()->id)
                                                <option value="{{ $member->id }}"
                                                    {{ $member->id ==auth()->guard('members')->user()->id? 'selected': '' }}>
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
                                    <input type="date" name="waqf_date" value="{{ old('waqf_date', date('Y-m-d')) }}"
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
                                <div class="form-group col">
                                    <div class="form-group col-md-6">
                                        <label for="soft_file" class="form-label"><span class="text-danger">*</span> Soft File (PDF)</label>
                                        <input type="file" name="soft_file" id="soft_file"
                                            class="form-control-file @error('soft_file') is-invalid @enderror" required>
                                        @error('soft_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="abstract" class="form-label"><span class="text-danger">*</span> Abstrak</label>
                                <textarea name="abstract" class="form-control @error('abstract') is-invalid @enderror mb-0" id="abstract"
                                    aria-describedby="abstract" required>{{ old('abstract') }}</textarea>
                                @error('abstract')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="page_count" class="form-label"><span class="text-danger">*</span> Total Halaman</label>
                                    <input type="number" name="page_count" value="{{ old('page_count') }}"
                                        placeholder="Jumlah Halaman .."
                                        class="form-control @error('page_count') is-invalid @enderror" id="page_count"
                                        aria-describedby="page_count" required>
                                    @error('page_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="payment_slip" class="form-label"><span class="text-danger">*</span> Bukti Pembayaran</label>
                                    <input type="file" name="payment_slip" id="payment_slip"
                                        class="form-control-file @error('payment_slip') is-invalid @enderror"
                                        onchange="previewImg()" required>
                                    @error('payment_slip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <img class="img-preview img-fluid mt-3 col-sm-5">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/transactions/waqfs" class="btn btn-success">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="float-right">
                                <a href="/admin/transactions/loans/create" class="btn btn-secondary">
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@prepend('scripts')
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Page specific script -->
    <script>
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
@endprepend
