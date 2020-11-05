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
use Carbon;

class AbsensiController extends Controller
{
   
    public function siswa()
    {
        $kelas = Kelas::all();
        $absensi = DB::table('absensis')
            ->select(
                'siswas.nis',
                'siswas.nama',
                DB::raw('gurus.nama as walikelas'),
                'kelas.namaKelas',
                'users.id',
                DB::raw('sum(absensis.keterangan = "hadir") as hadir'),
                DB::raw('sum(absensis.keterangan = "sakit") as sakit'),
                DB::raw('sum(absensis.keterangan = "izin") as izin'),
                DB::raw('sum(absensis.keterangan = "alfa") as alfa'),
                DB::raw('sum(absensis.keterangan = "dispensasi") as dispensasi')
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('siswas', 'users.username', '=', 'siswas.nis')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->join('gurus', 'kelas.guru_id', '=', 'gurus.id')
            ->groupBy('siswas.nis','siswas.nama','users.id','kelas.namaKelas','gurus.nama')->get();
        return view('absensi.absenSiswa', compact('absensi','kelas'));
    }
    
    public function rfid()
    {
        return view('absensi.absenRFID');
    }
    public function presensiall()
    {
        return view('absensi.presensiDashboard');
    }
    public function user(){
        
        $absensi = DB::table('absensis')
            ->select(
                'absensis.jam_masuk',
                'absensis.jam_pulang',
                'absensis.keterangan',
                'absensis.tgl_absen'
            )
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->where('users.id','=', auth()->user()->id)
            ->get();
        return view('absensi.absenUser', compact('absensi'));
    }
    public function detailSiswa($id){
        $decrypt = Crypt::decrypt($id);
        $absensi = DB::table('absensis')
            ->select(
                'siswas.nis',
                'siswas.nama',
                'users.id as user_id',
                'absensis.id',
                'absensis.jam_masuk',
                'absensis.jam_pulang',
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
                DB::raw('sum(absensis.keterangan = "dispensasi") as dispensasi')
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
                'absensis.jam_masuk',
                'absensis.jam_pulang',
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
                DB::raw('sum(absensis.keterangan = "dispensasi") as dispensasi')
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
                'absensis.jam_masuk',
                'absensis.jam_pulang',
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
        date_default_timezone_set('Asia/Jakarta');
        foreach($request->keterangan as $i => $sis){
            $cek = Absensi::where('tgl_absen', $request->tgl_absen)->where('user_id', $request->id[$i])->where('tipe', $request->tipe)->first();
            if( $cek != null ){
                $cek->keterangan = $request->keterangan[$i];
                $cek->jam_pulang = date('H:i:s');
                $cek->update();
            }else{
                $data[] = array(
                    'tgl_absen' => $request->tgl_absen,
                    'keterangan' => $request->keterangan[$i],
                    'tipe' => $request->tipe,
                    'jam_masuk' => date('H:i:s'),
                    'user_id' => $request->id[$i],
                );
            }
        }
        if(!empty($data)){
            DB::table('absensis')->insert($data); 

            foreach($data as $d){
                $user = User::where('id','=',$d['user_id'])->first();
                $massg = 'Presensi anda telah ditambahkan';
                Mail::send('email.pembayaranNotif', ['nama' => $user->name, 'pesan' => $massg], function ($message) use ($user)
                {
                    $message->subject('Presensi '.$user->name);
                    $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
                    $message->to($user->email);
                });
            }
            
        }
        Session::flash('success', 'Presensi berhasil ditambahkan');
        return Redirect::back();
    }
    public function storeRFID(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = DB::table('users')
            ->select('*','users.id as id')
            ->leftJoin('gurus', 'users.username', '=', 'gurus.nip')
            ->leftJoin('siswas', 'users.username', '=', 'siswas.nis')
            ->where('users.no_kartu','=',$request->no_kartu)
            ->first();
        // dd($user);
        // echo $user;
        if($user){
            $cek = Absensi::where('tgl_absen', date('Y-m-d'))->where('user_id', $user->id)->first();
           
            $absen = new Absensi;
            if( $cek != null ){
                $cek->jam_pulang =  date('H:i:s');
                $cek->update();
                $massg = 'Presensi pulang telah ditambahkan';
                Session::flash('success', 'Absen pulang ' . $user->name . ' berhasil ditambahkan');
            }else{
                $absen->tgl_absen =  date('Y-m-d');
                $absen->jam_masuk =  date('H:i:s');
                $absen->keterangan = 'hadir';
                $absen->tipe = $user->role;
                $absen->user_id = $user->id;
                $absen->save();
                $massg = 'Presensi masuk telah ditambahkan';
                Session::flash('success', 'Absen masuk ' . $user->name . ' berhasil ditambahkan');
            }
            // Mail::send('email.pembayaranNotif', ['nama' => $user->name, 'pesan' => $massg], function ($message) use ($user)
            //     {
            //         $message->subject('Absensi '.$user->name);
            //         $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
            //         $message->to($user->email);
            //     });
        }else{
           
            Session::flash('failed', 'Opps, kartu anda tidak terdaftar');
        }
        
        return Redirect::back();
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
        Session::flash('success', 'Presensi berhasil diubah');
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
