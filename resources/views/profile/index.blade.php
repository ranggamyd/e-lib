@extends('layouts.main')

@section('page')
    <div class="container">
        <div class="row my-4">
            <div class="col-md-10 offset-md-1">
                <h3 class="text-muted mb-3">Tentang {{ strtok($member->name, ' ') }}</h3>
                <div class="row">
                    <div class="col-md-4">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="/dist/img/avatar/{{ $member->avatar }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $member->name }}</h3>

                                <p class="text-muted text-center mb-0">{{ $member->npm }}</p>
                                <p class="text-muted text-center">{{ $member->subject->name }}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Buku yg dipinjam</b> <span
                                            class="float-right">{{ $borrowedBooks->count() }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Dikembalikan</b> <span
                                            class="float-right">{{ $borrowedBooks->where('status', 'Dikembalikan')->count() }}</span>
                                    </li>
                                </ul>

                                <a href="/admin/member/{{ $member->id }}"
                                    class="btn btn-primary btn-block"><b>Profil</b></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-8">
                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Info Lengkap</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button> --}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="far fa-file-alt mr-1"></i> Nama Lengkap</strong>
                                <p class="text-muted">{{ $member->name }}</p>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <strong><i class="far fa-id-badge mr-1"></i> Nomor Induk Mahasiswa</strong>
                                        <p class="text-muted">{{ $member->npm }}</p>
                                    </div>
                                    <div class="col">
                                        <strong><i class="fas fa-university mr-1"></i> Program Studi</strong>
                                        <p class="text-muted">{{ $member->subject->name }}</p>
                                    </div>
                                </div>
                                <hr class="mt-0">
                                <strong><i class="fas fa-birthday-cake mr-1"></i> Tempat, Tanggal Lahir</strong>
                                <p class="text-muted">{{ $member->birth }}</p>
                                <hr>
                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                                <p class="text-muted">{{ $member->address }}</p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
