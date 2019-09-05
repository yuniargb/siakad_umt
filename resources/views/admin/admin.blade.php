@extends('layout')
@section('content')
<div class="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
<div class="panel-header bg-primary">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h1 class="text-white pb-2 fw-bold">Admin</h1>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Daftar Admin</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-primary btn-round btn-sm btnAdminModal" data-action="add">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Admin
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admin as $adm)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $adm->name }}</td>
                                            <td class="text-primary">{{ $adm->username }}</td>
                                            <td>
                                                <div class="row">
                                                    <button type="button" class="btn btn-link btn-primary btnAdminModal" data-url="/admin/{{ Crypt::encrypt($adm->id) }}/edit" data-id="{{ Crypt::encrypt($adm->id) }}" data-toggle="tooltip" data-original-title="Edit" data-action="edit" data-method='@method("put")'><i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="/api/admin/{{ Crypt::encrypt($adm->id) }}" method="post" class="d-inline btn-del">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-link btn-danger" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-times"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminModalTitle">Tambah Admin Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin" id="adminForm" method="post">
                    @csrf
                    <div id="adminModalMethod"></div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
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