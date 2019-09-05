<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Oyago | Admin</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="/assets/img/icon.ico" type="image/x-icon" />

	<!-- Fonts and icons -->
	<script src="/assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Lato:300,400,700,900"]
			},
			custom: {
				"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['/assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/atlantis.css">
	<link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<div class="page-inner mt--5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Bukti Pembayaran SPP</div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                        <div class="col-md-12">
                            <div class="row">
                                <table>
                                <tr>
                                    <td>
                                        NIS 
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        {{ $pembayaran->nis }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Nama
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        {{ $pembayaran->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tanggal Transfer
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        {{ $pembayaran->tgl_transfer }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Bulan
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        {{ $pembayaran->bulan }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jumlah
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        {{ $pembayaran->jumlah }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Atm
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        {{ $pembayaran->atm }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Status
                                    </td>
                                     <td>
                                    :
                                    </td>
                                    <td>
                                        @php
                                        if($pembayaran->status == 0 )
                                        $pesan = '<span class="badge badge-danger">Menunggu Konfirmasi</span>';
                                        
                                        elseif($pembayaran->status == 3)
                                        
                                        $pesan = '<span class="badge badge-danger">Pembayaran Di Tolak</span>';
                                        
                                        else
                                        
                                        $pesan = '<span class="badge badge-success">Sudah Di Konfirmasi</span>';
                                        @endphp
                                        {!! $pesan !!}
                                    </td>
                                </tr>
                                </table>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	<!--   Core JS Files   -->
	<script src="/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="/assets/js/core/popper.min.js"></script>
	<script src="/assets/js/core/bootstrap.min.js"></script>

	
    <script>
		window.print();
	</script>
</body>

</html>