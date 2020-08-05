@extends('layout')
@section('title', 'Data Siswa')
@section('content')
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Daftar Siswa</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-primary btn-round btn-sm btnSiswaModal"
                            data-action="add">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Siswa
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                        aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Email</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Kelas</th>
                                            <th>Tahun Masuk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswa as $sw)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sw->nis }}</td>
                                            <td>{{ $sw->email }}</td>
                                            <td>{{ $sw->nama }}</td>
                                            <td>{{ ($sw->jk == 'l') ? 'Laki-laki' : 'Perempuan' }}</td>
                                            <td>{{ $sw->namaKelas }}</td>
                                            <td>{{ $sw->angkatan }}</td>
                                            <td>
                                                <div class="row">

                                                    <a href="/siswa/{{ Crypt::encrypt($sw->id) }}/pass"
                                                        class="btn btn-warning btn-passs" data-toggle="tooltip"
                                                        data-original-title="Atur Ulang Kata Sandi"><i
                                                            class="fa fa-key"></i></a>

                                                    <button type="button" data-toggle="modal" data-target="#logoutModal"
                                                        class="btn btn-primary btnSiswaModal"
                                                        data-url="/siswa/{{ Crypt::encrypt($sw->id) }}/edit"
                                                        data-id="{{ Crypt::encrypt($sw->id) }}" data-toggle="tooltip"
                                                        data-original-title="Ubah" data-action="ubah"
                                                        data-method='@method("put")'><i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="/api/siswa/{{ Crypt::encrypt($sw->id) }}"
                                                        method="post" class="d-inline btn-del">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger "
                                                            data-toggle="tooltip" data-original-title="Hapus"><i
                                                                class="fa fa-times"></i></button>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="siswaModalTitle">Tambah Siswa Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/siswa" id="siswaForm" class="siswa-form" method="post">
                    @csrf
                    <div id="siswaModalMethod"></div>
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input required type="text" class="form-control" name="nis" id="nis">
                        <small class="text-danger">{{ $errors->first('nis') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required type="email" class="form-control" name="email" id="email">
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input required type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="tglLahir">Tanggal Lahir</label>
                        <input required type="date" name="tgl_lahir" class="form-control" id="tglLahir">
                    </div>
                    <div class="form-group">
                        <label for="tempatLahir">Tempat Lahir</label>
                        <input required type="text" name="tempat_lahir" class="form-control" id="tempatLahir">
                    </div>
                    <div class="form-check">
                        <label>Jenis Kelamin</label><br />
                        <label class="form-radio-label">
                            <input required class="form-radio-input" type="radio" name="jk" value="l" checked=""
                                id="jkl">
                            <span class="form-radio-sign">Laki-laki</span>
                        </label>
                        <label class="form-radio-label ml-3">
                            <input required class="form-radio-input" type="radio" name="jk" value="p" id="jkp">
                            <span class="form-radio-sign">Perempuan</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select required name="agama" id="agama" class="form-control">
                            <optgroup label="Pilih Agama">
                                <option value="islam">Islam</option>
                                <option value="katholik">Kristen Katholik</option>
                                <option value="protestan">Kristen Protestan</option>
                                <option value="budha">Budha</option>
                                <option value="hindu">Hindu</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select required name="kelas" id="kelas" class="form-control">
                            <optgroup label="Pilih Kelas">
                                <option value=""></option>
                                @foreach($kelas as $kls)
                                <option value="{{ $kls->id }}">{{ $kls->namaKelas }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahunMasuk">Tahun Masuk</label>
                        <select required name="angkatan" id="angkatan" class="form-control">
                            <optgroup label="Pilih Angkatan">
                                <option value=""></option>
                                @foreach($angkatan as $ang)
                                <option value="{{ $ang->id }}">{{ $ang->angkatan }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
