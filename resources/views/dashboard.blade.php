@extends('layout')
@section('content')
<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                        aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <h3>Selamat Datang <b class="text-primary">{{ auth()->user()->name }}</b>
                            </h3>
                            @php
                            if(auth()->user()->role == 1){
                            $role = 'Staf Pembayaran';
                            }elseif(auth()->user()->role == 2){
                            $role = 'Siswa';
                            }elseif(auth()->user()->role == 3){
                            $role = 'Kepala Sekolah';
                            }elseif(auth()->user()->role == 5){
                            $role = 'Staf Pembelajaran';
                            }elseif(auth()->user()->role == 6){
                            $role = 'Staf Absensi';
                            }else{
                            $role = 'Administrasi';
                            }
                            @endphp
                            <h5>Anda login sebagai <b class="text-primary">{{ $role }}</b>
                            </h5>
                            <p class="text-justify">{!! $logo->biodata !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
