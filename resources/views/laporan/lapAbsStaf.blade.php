@extends('layout')
@section('title', 'Laporan Data Absen Staf')
@section('content')
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Laporan Absen Staf</div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                        aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <form action="/cetaklaporanabsenstaf" id="pembayaranForm" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nis">Dari Tanggal</label>
                                        <input type="date" class="form-control" name="from" id="from">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nis">Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="to" id="to">
                                    </div>
                                </div>
                                <div class="modal-footer col-md-12">
                                    <!-- <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-primary">Download</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="card mb-4 mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Diagram Absen Staf</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myBarChart" data-x="{{ json_encode($x) }}" data-y="{{ json_encode($y) }}"></canvas>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
@stop
