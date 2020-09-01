@extends('layout')
@section('title', 'Laporan Data Pembayaran Angkatan')
@section('content')
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Laporan Pembayaran Angkatan</div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                        aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <form action="/cetaklaporanpembayaranangkatan" class="form-row" id="pembayaranForm"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-md-6">
                                    <label for="nis">Bulan</label>
                                    <select class="form-control" name="bulan" id="bulan">
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desmber">Desember</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="angkatan">Angkatan</label>
                                    <select class="form-control" name="angkatan_id" id="angkatan">
                                        @foreach($angkatan as $k)
                                        <option value="{{ $k->id }}">{{ $k->angkatan }}</option>
                                        @endforeach
                                    </select>
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
        @if(!empty($pembayaran))
        <div class="card mb-4 mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Pembayaran Angkatan</h6>
            </div>
            <div class="card-body">
                <table border="1" class="table table-bordered table-condensed table basic-datatables">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal Transfer</th>
                            <th>Pembayaran Bulan</th>
                            <th>Tipe</th>
                            <th>Jumlah Transfer</th>
                            <th>Bank Transfer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $sw)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sw->nis }}</td>
                            <td>{{ $sw->nama }}</td>
                            <td>{{ $sw->namaKelas }}</td>
                            <td>{{ $sw->tgl_transfer }}</td>
                            <td>{{ $sw->bulan }}</td>
                            <td>{{ $sw->namatipe }}</td>
                            <td>{{ $sw->jumlah }}</td>
                            <td>{{ $sw->atm }}</td>
                            @php
                            if($sw->status == 0 )
                            $pesan = '<span class="badge badge-danger">Menunggu Konfirmasi</span>';

                            elseif($sw->status == 3)

                            $pesan = '<span class="badge badge-danger">Pembayaran Di Tolak</span>';

                            else

                            $pesan = '<span class="badge badge-success">Sudah Di Konfirmasi</span>';
                            @endphp
                            <td>{!! $pesan !!}</td>
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
                <h6 class="m-0 font-weight-bold text-primary">Diagram Pembayaran Angkatan</h6>
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
