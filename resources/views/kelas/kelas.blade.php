@extends('layout')
@section('content')
<div class="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
<div class="panel-header bg-primary">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h1 class="text-white pb-2 fw-bold">Kelas</h1>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Daftar Kelas</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-primary btn-round btn-sm btnKelasModal" data-action="add">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Kelas
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
                                            <th>Kelas</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kelas as $sw)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sw->namaKelas }}</td>
                                            <td>
                                                <div class="row">
                                                    <button type="button" class="btn btn-link btn-primary btnKelasModal" data-url="/kelas/{{ Crypt::encrypt($sw->id) }}/edit" data-id="{{ Crypt::encrypt($sw->id) }}" data-toggle="tooltip" data-original-title="Edit" data-action="edit" data-method='@method("put")'><i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="/api/kelas/{{ Crypt::encrypt($sw->id) }}" method="post" class="d-inline btn-del">
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
                <h5 class="modal-title" id="kelasModalTitle">Tambah Kelas Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/kelas" id="kelasForm" method="post">
                    @csrf
                    <div id="kelasModalMethod"></div>
                    <div class="form-group">
                        <label for="nis">Kelas</label>
                        <input type="text" class="form-control" name="kelas" id="kelas">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop