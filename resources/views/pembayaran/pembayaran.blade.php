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
                            <div class="container mb-3">
                                <ul class="list-group">
                                    <li class="list-group-item">NIS : {{ $siswa->nis }}</li>
                                    <li class="list-group-item">Nama : {{ $siswa->nama }}</li>
                                    <li class="list-group-item">Kelas : {{ $siswa->namaKelas }}</li>
                                    <li class="list-group-item">
                                        <a class="btn btn-link bg-primary text-light" href="/cetakpembayaran" data-toggle="tooltip" data-original-title="Download Excel"><i class="fa fa-download"></i> Download</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="">
                                <table class="table basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Siswa</th>
                                            <th>Tanggal</th>
                                            <th>Bulan</th>
                                            <th>Bukti</th>
                                            <th>Jumlah </th>
                                            <th>Bank</th>
                                            <th>Status</th>
                                            <th>Cetak</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pembayaran as $sw)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sw->nama }}</td>
                                            <td>{{ $sw->tgl_transfer }}</td>
                                            <td>{{ $sw->bulan }}</td>
                                            <td><img data-image="/images/paket/{{ $sw->bukti }}" src="/images/paket/{{ $sw->bukti }}" class="img-fluid detail-bukti" alt="{{ $sw->bukti }}" data-toggle="modal" data-target="#exampleModal"></td>
                                            <td>{{ $sw->jumlah }}</td>
                                            <td>{{ $sw->atm }}</td>
                                            @php
                                            if($sw->status == 0 )
                                            $pesan = '<span class="badge badge-danger">Menunggu</span>';

                                            elseif($sw->status == 3)

                                            $pesan = '<span class="badge badge-danger">Di Tolak</span>';

                                            else

                                            $pesan = '<span class="badge badge-success">Konfirmasi</span>';
                                            @endphp
                                            <td>{!! $pesan !!}</td>
                                            <td>
                                                <a class="btn btn-link btn-success" target="_blank" href="/cetakpembayaran/{{ Crypt::encrypt($sw->id_p) }}" data-toggle="tooltip" data-original-title="Cetak"><i class="fa fa-print"></i></a>
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
                        <label for="idsiswa">Nis</label>
                        <input type="text" class="form-control" name="idsiswa" id="idsiswa" value="{{ $siswa->nis }}" readonly required>
                        <input type="hidden" class="form-control" name="nis" id="nis" value="{{ $siswa->ids }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="atm">ATM</label>
                        <select class="form-control" name="atm" id="atm" required>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="BTN">BTN</option>
                            <option value="CIMB NIAGA">CIMB NIAGA</option>
                            <option value="PANIN">PANIN</option>
                            <option value="BRI">OCBC NISP</option>
                            <option value="BRI">MAYBANK INDONESIA</option>
                            <option value="BRI">DANAMON</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Transfer</label>
                        <input type="text" value="{{ $siswa->tarif }}" required class="form-control" name="jumlah" id="jumlahd" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nis">Bulan</label>
                        <select class="form-control" name="bulan" id="bulan" required>
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
                        <input type="date" class="form-control" name="tgl" id="tgl" required>
                    </div>

                    <div class="form-group">
                        <label for="nis">Bukti Transfer</label>
                        <input type="file" class="form-control" name="bukti" id="bukti" required>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" id="datagambar" class="img-fluid">
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
    @stop