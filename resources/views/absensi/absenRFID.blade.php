@extends('layout')
@section('title', 'Absen RFID')
@section('content')

<div class="page-inner mt--5" id="rfid-page">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                        aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <form action="/tambahabsenrfid" id="absenForm" method="post">
                                @csrf
                                @method('post')
                                <input type="number" name="no_kartu" id="no_kartu_auto" value="no_kartu" tabindex="-1"
                                    autofocus class="form-control col-md-6">
                            </form>

                            <p class="font-weight-bold text-center">Silahkan tempelkan kartu anda di alat RFID</p>
                            <div class="position-relative">
                                <div id="circle">
                                    <div class="circle one">
                                        <div class="circle two">
                                            <div class="circle three">
                                                <div class="circle four">
                                                    <div class="circle five">
                                                        <div class="circle six">
                                                            <div class="circle seven">
                                                                <div class="circle eight">
                                                                    <div class="circle nine">
                                                                        <div class="circle ten">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var alwaysFocusedInput = document.getElementById("no_kartu_auto");

    alwaysFocusedInput.addEventListener("blur", function () {
        setTimeout(() => {
            alwaysFocusedInput.focus();
        }, 0);
    });

</script>
@stop
