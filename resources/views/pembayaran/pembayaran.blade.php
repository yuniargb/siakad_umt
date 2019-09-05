@extends('layout')
@section('content')
<div class="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
<div class="panel-header bg-primary">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h1 class="text-white pb-2 fw-bold">Pembayaran</h1>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Daftar Pembayaran</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-primary btn-round btn-sm btnPembayaranModal" data-action="add">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Pembayaran
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
                                            <th>Siswa</th>
                                            <th>Tanggal Transfer</th>
                                            <th>Pembayaran Bulan</th>
                                            <th>Bukti</th>
                                            <th>Jumlah Transfer</th>
                                            <th>Bank Transfer</th>
                                            <th>Status</th>
                                            <th>Cetak</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pembayaran as $sw)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sw->nama }}</td>
                                            <td>{{ $sw->tgl_transfer }}</td>
                                            <td>{{ $sw->bulan }}</td>
                                            <td>{{ $sw->bukti }}</td>
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
                                            <td>
                                                <a class="btn btn-link btn-success" target="_blank" href="/cetakpembayaran/{{ Crypt::encrypt($sw->id_p) }}"  data-toggle="tooltip" data-original-title="Cetak"><i class="fa fa-print"></i></a>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <form action="/api/pembayaran/{{ Crypt::encrypt($sw->id_p) }}" method="post" class="d-inline btn-del">
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
                <h5 class="modal-title" id="pembayaranModalTitle">Tambah Pembayaran Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/pembayaran" id="pembayaranForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="PembayaranModalMethod"></div>
                    <div class="form-group">
                        <label for="nis">Nis</label>
                        <input type="text" class="form-control" name="idsiswa" id="idsiswa" value="{{ $siswa->nis }}" readonly>
                        <input type="hidden" class="form-control" name="nis" id="nis" value="{{ $siswa->id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nis">ATM</label>
                        <select class="form-control" name="atm" id="atm">
                            <option value="Mandiri">Mandiri</option>
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nis">Jumlah Transfer</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah">
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
                        <label for="nis">Tanggal Transfer</label>
                        <input type="date" class="form-control" name="tgl" id="tgl">
                    </div>
                    <div class="form-group">
                        <label for="nis">Bukti Transfer</label>
                        <input type="file" class="form-control" name="bukti" id="bukti">
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