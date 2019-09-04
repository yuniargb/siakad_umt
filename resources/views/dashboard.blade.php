@extends('layout')
@section('content')
<div class="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
<div class="panel-header bg-primary">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h1 class="text-white pb-2 fw-bold">Dashboard</h1>
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
                        <div class="col-md-12">
                            <h3>Selamat Datang di Aplikasi SPP <b class="text-primary">{{ auth()->user()->name }}</b></h3>
                            <h5>Anda login sebagai <b class="text-primary">{{ (auth()->user()->role == 1) ? 'Admin' : 'Siswa' }}</b></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop