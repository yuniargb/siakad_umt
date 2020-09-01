<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use App\Kelas;
use App\Logo;
use App\Angkatan;
use App\MataPelajaran;
use App\Exports\BulanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Response;

class LaporanController extends Controller
{
    public function pembayaran($pembayaran = null)
    {
        $kelas = Kelas::all();
        $diagram = DB::table('pembayarans')
            ->select(DB::raw('sum(pembayarans.jumlah) as jumlah'), 'tagihans.bulan')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->groupBy('bulan','jumlah')
            ->get();
        $x = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $y = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($diagram as $d) {
            $y[array_search($d->bulan, $x)] = $d->jumlah;
        }
        return view('laporan.lapPembayaran', compact('kelas','x','y','pembayaran'));
    }

    public function cetakpembayaran(Request $request)
    {

        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->where('tagihans.bulan', $request->bulan)
            ->where('siswas.kelas_id', $request->kelas)->get();
        
        
        if($request->submit == 'read'){
            return $this->pembayaran($pembayaran);
        }
        if($request->submit == 'csv'){
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=laporan-pembayaran-kelas-".date('dmyHis').".csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            
            $columns = array('NIS', 'Siswa','Tanggal Transfer','Pembayaran Bulan','Tipe','Jumlah Transfer','Bank Transfer','Status');

            $callback = function() use ($pembayaran, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($pembayaran as  $sw) {
                    if($sw->status == 0 )
                        $pesan = 'Menunggu Konfirmasi';
                    elseif($sw->status == 3)
                        $pesan = 'Pembayaran Di Tolak';
                    else
                        $pesan = 'Sudah Di Konfirmasi';
                    fputcsv($file, array($sw->nis,$sw->nama,$sw->tgl_transfer,$sw->bulan,$sw->namatipe,$sw->jumlah,$sw->atm,$pesan));
                }
                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        }
        if($request->submit == 'pdf'){
            $bulan = $request->bulan;
            $kelas = Kelas::find($request->kelas);
            $logo = Logo::find(1);
            $pdf = PDF::loadview('laporan.cetakPembayaran', compact('pembayaran','kelas', 'bulan','logo'));
            return $pdf->download('laporan-pembayaran-kelas-'.date('dmyHis'));
        }
    }

    public function pembayaranangkatan()
    {
        $angkatan = Angkatan::all();
        $diagram = DB::table('pembayarans')
            ->select(DB::raw('sum(pembayarans.jumlah) as jumlah'), 'angkatans.angkatan')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('angkatans', 'siswas.angkatan_id', '=', 'angkatans.id')
            ->groupBy('angkatans.angkatan','jumlah')
            ->get();
        $x = [];
        $y = [];
        foreach ($angkatan as $a){
            array_push($x,$a->angkatan);
            array_push($y,0);
        }
        foreach ($diagram as $d) {
            $y[array_search($d->angkatan, $x)] = $d->jumlah;
        }
        return view('laporan.lapPembayaranAngkatan', compact('angkatan','x','y'));
        
    }

    public function cetakpembayaranangkatan(Request $request)
    {

        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('angkatans', 'siswas.angkatan_id', '=', 'angkatans.id')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->where('tagihans.bulan', $request->bulan)
            ->where('angkatans.id', $request->angkatan_id)->get();
        
        

        if($request->submit == 'read'){
            return $this->pembayaran($pembayaran);
        }
        if($request->submit == 'csv'){
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=laporan-pembayaran-angkatan-".date('dmyHis').".csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            
            $columns = array('NIS', 'Siswa','kelas','Tanggal Transfer','Pembayaran Bulan','Tipe','Jumlah Transfer','Bank Transfer','Status');

            $callback = function() use ($pembayaran, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($pembayaran as  $sw) {
                    if($sw->status == 0 )
                        $pesan = 'Menunggu Konfirmasi';
                    elseif($sw->status == 3)
                        $pesan = 'Pembayaran Di Tolak';
                    else
                        $pesan = 'Sudah Di Konfirmasi';
                    fputcsv($file, array($sw->nis,$sw->nama,$sw->namaKelas,$sw->tgl_transfer,$sw->bulan,$sw->namatipe,$sw->jumlah,$sw->atm,$pesan));
                }
                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        }
        if($request->submit == 'pdf'){
       

            $angkatan = Angkatan::find($request->angkatan_id);
            $bulan = $request->bulan;
            $logo = Logo::find(1);
    
            $pdf = PDF::loadview('laporan.cetakPembayaranAngkatan', compact('pembayaran', 'bulan','angkatan','logo'));
            return $pdf->download('laporan-pembayaran-angkatan-'.date('dmyHis'));
        }
    }


   public function penilaian($penilaian = null)
    {
        
        $diagram = DB::table('nilais')
            ->select(DB::raw('count(nilais.id) as jumlah'), 'nilais.tipe')
            ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
            ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
            ->join('users', 'users.username', '=', 'gurus.nip')
            ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
            ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
            ->groupBy('nilais.tipe')
            ->get();
        $x = ['harian','ujian','raport'];
        $y = [0,0,0];
        foreach ($diagram as $d) {
            $y[array_search($d->tipe, $x)] = $d->jumlah;
        }
        return view('laporan.lapPenilaian', compact('x','y','penilaian'));
    }

    public function cetakpenilaian(Request $request)
    {
        $penilaian = DB::table('nilais')
            ->select('*','nilais.id as id')
           ->join('jadwals', 'jadwals.id', '=', 'nilais.jadwal_id')
            ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
            ->join('users', 'users.username', '=', 'gurus.nip')
            ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'jadwals.mata_pelajaran_id')
            ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
            ->where('nilais.tipe', $request->tipe)
            ->where('nilais.semester', $request->semester)
            ->where('nilais.tahun_ajaran', $request->tahun_ajaran)
            ->orderBy('mata_pelajarans.id')
            ->get();
        if($request->submit == 'read'){
            return $this->penilaian($penilaian);
        }
        if($request->submit == 'csv'){
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=laporan-penilaian-".date('dmyHis').".csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            
            $columns = array('Siswa', 'Kelas','Mata Pelajaran','Nilai');

            $callback = function() use ($penilaian, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($penilaian as  $sw) {
                    fputcsv($file, array($sw->nama,$sw->namaKelas,$sw->namamapel,$sw->nilai));
                }
                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        }
        if($request->submit == 'pdf'){
            $tipe = $request->tipe;
            $semester = $request->semester;
            $tahun_ajaran = $request->tahun_ajaran;
    
            $logo = Logo::find(1);
            
            $pdf = PDF::loadview('laporan.cetakPenilaian', compact('penilaian', 'tipe','semester','tahun_ajaran','logo'));
            return $pdf->download('laporan-penilaian-'.date('dmyHis'));
        }
    }

    public function rppdansilabus()
    {
        $mapel = MataPelajaran::all();
        return view('laporan.lapRDS', compact('mapel'));
    }

    public function cetakrppdansilabus(Request $request)
    {
        $rds = DB::table('silabus_dan_rpps')
            ->select('*','silabus_dan_rpps.id as id')
            ->join('mata_pelajarans', 'silabus_dan_rpps.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->where('mata_pelajarans.id',$request->mata_pelajaran_id)
            ->where('silabus_dan_rpps.semester',$request->semester)
            ->where('silabus_dan_rpps.tahun_ajaran',$request->tahun_ajaran)
            ->where('silabus_dan_rpps.kelas',$request->kelas)
            ->first();
        if($rds == null)
            return Redirect::back()->with('success', 'Data tidak ditemukan');
           
        $logo = Logo::find(1);

        $pdf = PDF::loadview('laporan.cetakRDS', compact('rds', 'logo'));
    	return $pdf->download('laporan-RDS');
    }

    public function jadwal()
    {
        $kelas = Kelas::all();
        return view('laporan.lapJadwal', compact('kelas'));
    }

    public function cetakjadwal(Request $request)
    {
        $jadwal = DB::table('jadwals')
            ->select('*', 'jadwals.id as id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
            ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->where('jadwals.kelas_id', $request->kelas_id)
            ->where('jadwals.tahun_ajaran', $request->tahun_ajaran)
            ->get();
        $tahun_ajaran = $request->tahun_ajaran;
        $kelas = Kelas::find($request->kelas_id);
        $logo = Logo::find(1);
        $pdf = PDF::loadview('laporan.cetakJadwal', compact('jadwal', 'logo','kelas','tahun_ajaran'));
    	return $pdf->download('laporan-Jadwal');
    }
    public function absenSiswa($absensi=null)
    {
        $kelas = Kelas::all();
        $diagram = DB::table('absensis')
            ->select(
                DB::raw('count(absensis.keterangan) as jumlah'),
                'absensis.keterangan'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('siswas', 'users.username', '=', 'siswas.nis')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->groupBy('absensis.keterangan')->get();
        $x = ['Hadir','Sakit','Izin','Alfa','Dispensasi'];
        $y = [0,0,0,0,0];
        foreach ($diagram as $d) {
            $y[array_search($d->keterangan, $x)] = $d->jumlah;
        }
        return view('laporan.lapAbsSiswa', compact('kelas','x','y','absensi'));
    }
    public function absenGuru($absensi=null)
    {
         $diagram = DB::table('absensis')
             ->select(
                DB::raw('count(absensis.keterangan) as jumlah'),
                'absensis.keterangan'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('gurus', 'users.username', '=', 'gurus.nip')
            ->groupBy('absensis.keterangan')->get();
        $x = ['Hadir','Sakit','Izin','Alfa','Dispensasi'];
        $y = [0,0,0,0,0];
        foreach ($diagram as $d) {
            $y[array_search($d->keterangan, $x)] = $d->jumlah;
        }
        return view('laporan.lapAbsGuru',compact('x','y','absensi'));
    }
    public function absenStaf($absensi=null)
    {
        $diagram = DB::table('absensis')
             ->select(
                DB::raw('count(absensis.keterangan) as jumlah'),
                'absensis.keterangan'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->where('role', '<>' ,2)
            ->where('role','<>',7)
            ->groupBy('absensis.keterangan')->get();
        $x = ['Hadir','Sakit','Izin','Alfa','Dispensasi'];
        $y = [0,0,0,0,0];
        foreach ($diagram as $d) {
            $y[array_search($d->keterangan, $x)] = $d->jumlah;
        }
        return view('laporan.lapAbsStaf',compact('x','y','absensi'));
    }

    public function cetakAbsSiswa(Request $request)
    {
         $absensi = DB::table('absensis')
            ->select(
                'absensis.tgl_absen',
                'siswas.nis',
                'siswas.nama',
                'users.id',
                'absensis.keterangan',
                'absensis.jam_masuk',
                'absensis.jam_pulang'
                
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('siswas', 'users.username', '=', 'siswas.nis')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->where('kelas.id','=',$request->kelas_id)
            ->whereBetween ('absensis.tgl_absen',[$request->from,$request->to])
            ->orderBy('siswas.nis','asc')->get(); 
        if($request->submit == 'read'){
            return $this->absenSiswa($absensi);
        }
        if($request->submit == 'csv'){
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=laporan-presensi-siswa-".date('dmyHis').".csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            
            $columns = array('Tanggal', 'Nis','Nama','Jam Masuk','Jam Pulang','Keterangan');

            $callback = function() use ($absensi, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($absensi as  $sw) {
                    fputcsv($file, array($sw->tgl_absen,$sw->nis,$sw->nama,$sw->jam_masuk,$sw->jam_pulang,$sw->keterangan));
                }
                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        }
        if($request->submit == 'pdf'){
            $kelas = Kelas::find($request->kelas_id);
            $logo = Logo::find(1);
            $pdf = PDF::loadview('laporan.cetakAbsSiswa', compact('absensi', 'logo','kelas'));
            return $pdf->download('laporan-Presensi-Siswa-'.date('dmyHis'));
        }
    }
    public function cetakAbsGuru(Request $request)
    {
         $absensi = DB::table('absensis')
            ->select(
                'absensis.tgl_absen',
                'gurus.nip',
                'gurus.nama',
                'users.id',
                'absensis.keterangan',
                'absensis.jam_masuk',
                'absensis.jam_pulang'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('gurus', 'users.username', '=', 'gurus.nip')
            ->whereBetween ('absensis.tgl_absen',[$request->from,$request->to])
            ->orderBy('gurus.nip','asc')->get();
        
        
        if($request->submit == 'read'){
            return $this->absenGuru($absensi);
        }
        if($request->submit == 'csv'){
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=laporan-presensi-guru-".date('dmyHis').".csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            
            $columns = array('Tanggal', 'Nip','Nama','Jam Masuk','Jam Pulang','Keterangan');

            $callback = function() use ($absensi, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($absensi as  $sw) {
                    fputcsv($file, array($sw->tgl_absen,$sw->nip,$sw->nama,$sw->jam_masuk,$sw->jam_pulang,$sw->keterangan));
                }
                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        }
        if($request->submit == 'pdf'){
       

            $logo = Logo::find(1);
            $pdf = PDF::loadview('laporan.cetakAbsGuru', compact('absensi', 'logo'));
            return $pdf->download('laporan-Presensi-Guru-'.date('dmyHis'));
        }
    }
    public function cetakAbsStaf(Request $request)
    {
         $absensi = DB::table('absensis')
            ->select(
                'absensis.tgl_absen',
                'users.username',
                'users.name',
                'users.id',
                'absensis.keterangan',
                'absensis.jam_masuk',
                'absensis.jam_pulang'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->where('role', '<>' ,2)
            ->where('role','<>',7)
            ->whereBetween ('absensis.tgl_absen',[$request->from,$request->to])
            ->orderBy('users.username','asc')->get();
        
        
        if($request->submit == 'read'){
            return $this->absenStaf($absensi);
        }
        if($request->submit == 'csv'){
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=laporan-presensi-staf-".date('dmyHis').".csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            
            $columns = array('Tanggal', 'Username','Nama','Jam Masuk','Jam Pulang','Keterangan');

            $callback = function() use ($absensi, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach($absensi as  $sw) {
                    fputcsv($file, array($sw->tgl_absen,$sw->username,$sw->name,$sw->jam_masuk,$sw->jam_pulang,$sw->keterangan));
                }
                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        }
        if($request->submit == 'pdf'){
       

            $logo = Logo::find(1);
            $pdf = PDF::loadview('laporan.cetakAbsStaf', compact('absensi', 'logo'));
            return $pdf->download('laporan-Presensi-Staf-'.date('dmyHis'));
        }
    }
}
