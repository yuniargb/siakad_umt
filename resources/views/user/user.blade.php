@extends('layout')
@section('content')
<div class="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
<div class="panel-header bg-primary">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h1 class="text-white pb-2 fw-bold">Profle</h1>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    @if(auth()->user()->role == 2)
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{ $user->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>{{ $user->kelas->namaKelas }}</td>
                                    </tr>
                                    <tr>
                                        <td>Angkatan</td>
                                        <td>{{ $user->angkatan->angkatan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tarif SPP</td>
                                        <td>Rp {{ number_format($user->angkatan->tarifspp,0,',','.') }}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Username</td>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                </table>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block btnEditUser" data-url="/admin/{{ Crypt::encrypt($user->id) }}/edit">Update Profile <i class="fa fa-pencil-alt"></i></button>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editModalUser" tabindex="-1" role="dialog" aria-labelledby="editModalUserTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminModalTitle">Update Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/{{ Crypt::encrypt($user->id) }}/update" id="adminForm" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop