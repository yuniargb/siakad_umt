@php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Laporan-Pembayaran.xls");
@endphp
<table>
	<tr>
		<td colspan="3">

		</td>
		<td height="60" style="border:none !important; text-align:center;" align="center">
			<center>
				<img src="{{ url('images/logo.jpg') }}" width="80" height="60" alt="" style="text-align: center;">
			</center>
		</td>
		<td colspan="4">
			<h1 class="text-center">Data Pembayaran</h1>

		</td>
	</tr>
</table>
<table border="1" class="table basic-datatables">
	<thead>
		<tr>
			<th border="1">No</th>
			<th>NIS</th>
			<th>Siswa</th>
			<th>Tanggal Transfer</th>
			<th>Pembayaran Bulan</th>
			<!-- <th>Bukti</th> -->
			<th>Jumlah Transfer</th>
			<th>Bank Transfer</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pembayaran as $sw)
		<tr border="1">
			<td>{{ $loop->iteration }}</td>
			<td>{{ $sw->nis }}</td>
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
		</tr>
		@endforeach
	</tbody>
</table>