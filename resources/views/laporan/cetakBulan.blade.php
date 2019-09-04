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
    @php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Laporan-Pembayaran.xls");
	@endphp
	<h1 class="text-center">Laporan Pembayaran Bualanan</h1>
	<h1 class="text-center">Bulan {{ $bulan }}</h1>
	<table class="table basic-datatables">
		<thead>
			<tr>
				<th>No</th>
				<th>Siswa</th>
				<th>Tanggal Transfer</th>
				<th>Pembayaran Bulan</th>
				<!-- <th>Bukti</th> -->
				<th>Jumlah Transfer</th>
				<th>Bank Transfer</th>
				<th>Status</th>
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
				<!-- <td>{{ $sw->bukti }}</td> -->
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
					<div class="row">
						
							<button type="button" class="btn btn-link btn-danger kon" data-url="/accpembayaran/{{ Crypt::encrypt($sw->id_p) }}/3"  data-toggle="tooltip" value="tolak" data-original-title="Tolak"><i class="fa fa-times"></i></button>
							<button type="button" class="btn btn-link btn-primary kon" data-url="/accpembayaran/{{ Crypt::encrypt($sw->id_p) }}/1" data-toggle="tooltip" value="konfirmasi" data-original-title="Konfirmasi"><i class="fa fa-check"></i></button>
		
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

    
	<!--   Core JS Files   -->
	<script src="/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="/assets/js/core/popper.min.js"></script>
	<script src="/assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="/assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="/assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="/assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="/assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

	<!-- Atlantis JS -->
	<script src="/assets/js/atlantis.min.js"></script>

	<!-- My Script -->
	<script src="/js/script.js"></script>
</body>

</html>
