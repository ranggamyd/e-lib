@extends('admin.layouts.main')

@prepend('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/transactions/users">Users</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endprepend

@section('page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="/dist/img/avatar/{{ $user->avatar }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center mb-0">{{ $user->username }}</p>
                        <p class="text-muted text-center">{{ $user->role }}</p>

                        <a href="/admin/users" class="btn btn-secondary btn-block"><i class="fas fa-arrow-left mr-2"></i><b>Kembali</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#users" data-toggle="tab">Tentang
                                    {{ strtok($user->name, ' ') }}</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="users">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="border-top-0">Nama Lengkap</th>
                                            <td class="border-top-0">{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Username</th>
                                            <td>{{ $user->username }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tempat, Tanggal Lahir</th>
                                            <td>{{ $user->birth }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Jenis Kelamin</th>
                                            <td>{{ $user->gender }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Alamat</th>
                                            <td>{!! $user->address !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection
