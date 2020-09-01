@extends('layout')
@section('title', 'Laporan Data Presensi Siswa')
@section('content')
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Laporan Presensi Siswa</div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                        aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <form action="/cetaklaporanabsensiswa" id="pembayaranForm" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nis">Kelas</label>
                                    <select class="form-control" name="kelas_id" id="kelas_id">
                                        @foreach($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->namaKelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                                    <button name="submit" type="submit" class="btn btn-success"
                                        value="read">Tampil</button>
                                    <button name="submit" type="submit" class="btn btn-info" value="csv">Download
                                        CSV</button>
                                    <button name="submit" type="submit" class="btn btn-primary" value="pdf">Download
                                        PDF</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($absensi))
        <div class="card mb-4 mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Presensi Siswa</h6>
            </div>
            <div class="card-body">
                <table border="1" class="table table-bordered table-condensed table basic-datatables">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensi as $sw)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sw->tgl_absen }}</td>
                            <td>{{ $sw->nis }}</td>
                            <td>{{ $sw->nama }}</td>
                            <td>{{ $sw->jam_masuk }}</td>
                            <td>{{ $sw->jam_pulang }}</td>
                            <td>{{ $sw->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
        @endif
        <!-- Bar Chart -->
        <div class="card mb-4 mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Diagram Presensi Siswa</h6>
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
