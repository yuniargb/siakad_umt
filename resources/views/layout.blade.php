<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Administrasi MTs Al-Muhtadiin</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="/images/logo.jpg" type="image/x-icon" />

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
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue2">

				<a class="logo">
					<!-- <img src="/assets/img/logo.svg" alt="navbar brand" class="navbar-brand"> -->
					<h4 class="text-white navbar-brand">MTS AL Muhtadiin</h4>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="/images/logo.jpg" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="/images/logo.jpg" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>{{ auth()->user()->name }}</h4>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="/user">Biodata</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item  btn-logout" href="/logout">Keluar</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2" data-background-color="blue">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="/images/logo.jpg" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a aria-expanded="true">
								<span>
									{{ auth()->user()->name }}
									@php
									if(auth()->user()->role == 1){
									$role = 'Admin';
									}elseif(auth()->user()->role == 2){
									$role = 'Siswa';
									}elseif(auth()->user()->role == 3){
									$role = 'Kepala Sekolah';
									}else{
									$role = 'Super Admin';
									}
									@endphp
									<span class="user-level">{{ $role }}</span>
								</span>
							</a>
							<div class="clearfix"></div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">MENU UTAMA</h4>
						</li>
						@if(auth()->user()->role == 2)
						<!-- <li class="nav-item">
							<a href="/">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li> -->
						<li class="nav-item">
							<a href="/pembayaran">
								<i class="fas fa-desktop"></i>
								<p>Pembayaran</p>
								<!-- <span class="badge badge-success">4</span> -->
							</a>
						</li>
						@elseif(auth()->user()->role == 1 || auth()->user()->role == 4)
						<li class="nav-item">
							<a href="/siswa">
								<i class="fas fa-users"></i>
								<p>Data Siswa</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/kelas">
								<i class="fas fa-building"></i>
								<p>Data Kelas</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/spp">
								<i class="fas fa-paste"></i>
								<p>SPP</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/accpembayaran">
								<i class="fas fa-desktop"></i>
								<p>Konfirmasi Pembayaran</p>
								<!-- <span class="badge badge-success">5</span> -->
							</a>
						</li>
						@if(auth()->user()->role == 4)
						<li class="nav-item">
							<a href="/admin">
								<i class="fas fa-user"></i>
								<p>Admin</p>
							</a>
						</li>
						@endif
						<li class="nav-item">
							<a data-toggle="collapse" href="#base">
								<i class="fas fa-layer-group"></i>
								<p>Laporan</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="base">
								<ul class="nav nav-collapse">
									<li>
										<a href="/laporanbulan">
											<span class="sub-item">Laporan Pembayaran</span>
										</a>
										<!-- <a href="/product">
											<span class="sub-item">Items</span>
										</a> -->
									</li>
								</ul>
							</div>
						</li>
						@elseif(auth()->user()->role == 3)
						<li class="nav-item">
							<a data-toggle="collapse" href="#base">
								<i class="fas fa-layer-group"></i>
								<p>Laporan</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="base">
								<ul class="nav nav-collapse">
									<li>
										<a href="/laporanbulan">
											<span class="sub-item">Laporan Pembayaran</span>
										</a>
										<!-- <a href="/product">
											<span class="sub-item">Items</span>
										</a> -->
									</li>
								</ul>
							</div>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				@yield('content')
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright ml-auto">
						2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com">ThemeKita</a>
					</div>
				</div>
			</footer>
		</div>
	</div>
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

	<!-- Laravel Javascript Validation -->
	<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('.btn-passs').on('click', function(e) {
				console.log('ok')
				let url = $(this).attr('href')
				console.log(url)
				let text = $(this).data('original-title')
				e.preventDefault();
				Swal.fire({
					title: 'Are you sure?',
					text: "You won't be change to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: text
				}).then((result) => {
					if (result.value) {
						document.location.href = url;
					}
				});
			});
		});
	</script>

</body>

</html>