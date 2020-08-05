<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Siswa;
use App\Guru;
use App\User;
use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use DB;
use Mail;

class AbsensiController extends Controller
{
   
    public function siswa()
    {
        $kelas = Kelas::all();
        $absensi = DB::table('absensis')
            ->select(
                'siswas.nis',
                'siswas.nama',
                'kelas.namaKelas',
                'users.id',
                DB::raw('sum(absensis.keterangan = "hadir") as hadir'),
                DB::raw('sum(absensis.keterangan = "sakit") as sakit'),
                DB::raw('sum(absensis.keterangan = "izin") as izin'),
                DB::raw('sum(absensis.keterangan = "alfa") as alfa'),
                DB::raw('sum(absensis.keterangan = "dispensasi") as dispensasi'),
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('siswas', 'users.username', '=', 'siswas.nis')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->groupBy('siswas.nis','siswas.nama','users.id','kelas.namaKelas')->get();
        return view('absensi.absenSiswa', compact('absensi','kelas'));
    }
    
    public function detailSiswa($id){
        $decrypt = Crypt::decrypt($id);
        $absensi = DB::table('absensis')
            ->select(
                'siswas.nis',
                'siswas.nama',
                'users.id as user_id',
                'absensis.id',
                'absensis.keterangan',
                'absensis.tgl_absen'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('siswas', 'users.username', '=', 'siswas.nis')
            ->where('users.id','=',$decrypt)
            ->get();
        return $absensi;
    }
    public function guru()
    {
        $guru = DB::table('gurus')
            ->select('*', 'users.id as id')
            ->join('users', 'gurus.nip', '=', 'users.username')
            ->where('role','=',7)->get();
        $absensi = DB::table('absensis')
            ->select(
                'gurus.nip',
                'gurus.nama',
                'users.id',
                DB::raw('sum(absensis.keterangan = "hadir") as hadir'),
                DB::raw('sum(absensis.keterangan = "sakit") as sakit'),
                DB::raw('sum(absensis.keterangan = "izin") as izin'),
                DB::raw('sum(absensis.keterangan = "alfa") as alfa'),
                DB::raw('sum(absensis.keterangan = "dispensasi") as dispensasi'),
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('gurus', 'users.username', '=', 'gurus.nip')
            ->groupBy('gurus.nip','gurus.nama','users.id')->get();
        return view('absensi.absenGuru', compact('absensi','guru'));
    }
    public function detailGuru($id){
        $decrypt = Crypt::decrypt($id);
        $absensi = DB::table('absensis')
            ->select(
                'gurus.nama',
                'absensis.id',
                'absensis.keterangan',
                'absensis.tgl_absen'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('gurus', 'users.username', '=', 'gurus.nip')
            ->where('users.id','=',$decrypt)
            ->get();
        return $absensi;
    }
    public function staf()
    {
        $staf = DB::table('users')
            ->select('*')
            ->where('role', '<>' ,2)
            ->where('role','<>',7)->get();
        $absensi = DB::table('absensis')
             ->select(
                'users.email',
                'users.name',
                'users.id',
                DB::raw('sum(absensis.keterangan = "hadir") as hadir'),
                DB::raw('sum(absensis.keterangan = "sakit") as sakit'),
                DB::raw('sum(absensis.keterangan = "izin") as izin'),
                DB::raw('sum(absensis.keterangan = "alfa") as alfa'),
                DB::raw('sum(absensis.keterangan = "dispensasi") as dispensasi'),
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->where('role', '<>' ,2)
            ->where('role','<>',7)
             ->groupBy('users.email','users.name','users.id','users.role')->get();
        return view('absensi.absenStaf', compact('absensi','staf'));
    }
    public function detailStaf($id){
        $decrypt = Crypt::decrypt($id);
        $absensi = DB::table('absensis')
            ->select(
                'users.name as nama',
                'absensis.id',
                'absensis.keterangan',
                'absensis.tgl_absen'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->where('users.id','=',$decrypt)
            ->get();
        return $absensi;
    }
    public function create()
    {
        //
    }
    public function storeManual(Request $request)
    {  
        foreach($request->keterangan as $i => $sis){
            $cek = Absensi::where('tgl_absen', $request->tgl_absen)->where('user_id', $request->id[$i])->where('tipe', $request->tipe)->first();
            if( $cek != null ){
                $cek->keterangan = $request->keterangan[$i];
                $cek->update();
            }else{
                $data[] = array(
                    'tgl_absen' => $request->tgl_absen,
                    'keterangan' => $request->keterangan[$i],
                    'tipe' => $request->tipe,
                    'user_id' => $request->id[$i],
                );
            }
        }
        if(!empty($data)){
            DB::table('absensis')->insert($data); 

            foreach($data as $d){
                $user = User::where('id','=',$d['user_id'])->first();
                $massg = 'Absen anda telah ditambahkan';
                Mail::send('email.pembayaranNotif', ['nama' => $user->name, 'pesan' => $massg], function ($message) use ($user)
                {
                    $message->subject('Absensi '.$user->name);
                    $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
                    $message->to($user->email);
                });
            }
            
        }
        Session::flash('success', 'Absen berhasil ditambahkan');
        return Redirect::back();
    }
    public function storeRFID($tipe, Request $request)
    {
        $absen = new Absen;
        $absen->tgl_absen = $request->tgl_absen;
        $absen->keterangan = $request->keterangan;
        $absen->tipe = $request->tipe;
        $absen->jam_masuk = $request->jam_masuk;
        $absen->jam_pulang = $request->jam_pulang;
        if($request->tipe == 'siswa')
            $absen->user_id = $request->siswa_id;
        if($request->tipe == 'staf')
            $absen->user_id = $request->staf_id;
        if($request->tipe == 'guru')
            $absen->user_id = $request->guru_id;
        $absen->save();
    }

  
    public function show($id)
    {
        //
    }

    public function update(Request $request)
    {
        foreach($request->keterangan as $i => $sis){
            $cek = Absensi::find($request->id[$i]);
            $cek->keterangan = $request->keterangan[$i];
            $cek->update();
        }
        Session::flash('success', 'Absen berhasil diubah');
        return Redirect::back();
    }

    // public function destroy($id)
    // {
    //     $decrypt = Crypt::decrypt($id);
    //     $kelas = Kelas::find($decrypt);
    //     $kelas->delete();

    //     Session::flash('success', 'Kelas berhasil dihapus');
    //     return '/kelas';
    // }
}
