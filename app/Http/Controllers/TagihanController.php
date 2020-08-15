<?php

namespace App\Http\Controllers;

use App\Tagihan;
use App\TipePembayaran;
use App\Pembayaran;
use App\Kelas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PDF;
use Mail;
class TagihanController extends Controller
{
    public function index()
    {
        // $pembayaran = Pembayaran::with('siswa')->first();
        $kelas = Kelas::all();
        $tipe = TipePembayaran::all();
        $tagihan = DB::table('tagihans')
            ->select('tagihans.id as id','tagihans.kelas_id','tagihans.bulan','tagihans.tahun','kelas.namaKelas','tipe_pembayarans.namatipe',DB::raw('count(pembayarans.tagihan_id IS NULL) as belum'),DB::raw('count(pembayarans.tagihan_id != "") as sudah'))
            ->join('kelas', 'tagihans.kelas_id', '=', 'kelas.id')
            ->join('siswas', 'kelas.id', '=', 'siswas.kelas_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->leftJoin('pembayarans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->groupBy('tagihans.id','tagihans.kelas_id','tagihans.bulan','tagihans.tahun','kelas.namaKelas','tipe_pembayarans.namatipe')
            ->get();
        return view('pembayaranAdmin.tagihan', compact('tagihan','kelas','tipe'));
    }
    public function detail($kelas_id,$id)
    {
        $idd = Crypt::decrypt($id);
        $kelasd = Crypt::decrypt($kelas_id);
        
        $tagihan = DB::table('tagihans')
            ->select('*', 'tagihans.id as id')
            ->join('kelas', 'tagihans.kelas_id', '=', 'kelas.id')
            ->join('siswas', 'kelas.id', '=', 'siswas.kelas_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->leftJoin(DB::raw('(select * from pembayarans where tagihan_id = '.$idd.') as pembayarans'), 'siswas.id', '=', 'pembayarans.siswa_id')
            ->where('kelas.id', '=', $kelasd)
            ->where('tagihans.id', '=', $idd)
            ->get();
        return $tagihan;
    }
    public function email($kelas_id,$id)
    {
        $idd = Crypt::decrypt($id);
        $kelasd = Crypt::decrypt($kelas_id);
        $tagihan = DB::table('tagihans')
            ->select('*', 'tagihans.id as id')
            ->join('kelas', 'tagihans.kelas_id', '=', 'kelas.id')
            ->join('siswas', 'kelas.id', '=', 'siswas.kelas_id')
            ->join('users', 'users.username', '=', 'siswas.nis')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->leftJoin(DB::raw('(select * from pembayarans where tagihan_id = '.$idd.') as pembayarans'), 'siswas.id', '=', 'pembayarans.siswa_id')
            ->where('kelas.id', '=', $kelasd)
            ->whereNull('pembayarans.id')
            ->get();
        foreach($tagihan as $d){
            $massg = 'Ada tagihan anda bulan '.$d->bulan.' tahun '. $d->tahun.' belum dibayar,silahkan lakukan pembayaran secepatnya :)';
            Mail::send('email.pembayaranNotif', ['nama' => $d->nama, 'pesan' => $massg], function ($message) use ($d)
            {
                $message->subject('Hi '.$d->nama.' ada tagihan belum dibayar');
                $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
                $message->to($d->email);
            });
        }
        Session::flash('success', 'Tagihan berhasil dikirimkan');
        return Redirect::back();
    }
    
     public function store(Request $request)
    {
        $tagihan = new Tagihan;
        $tagihan->bulan =   $request->bulan;
        $tagihan->tahun =  $request->tahun;
        $tagihan->kelas_id = $request->kelas_id;
        $tagihan->tipe_pembayaran_id = $request->tipe_pembayaran_id;
        $tagihan->save();

        $user = DB::table('users')
            ->select('*','users.id as id')
            ->join('siswas', 'users.username', '=', 'siswas.nis')
            ->where('siswas.kelas_id','=',$request->kelas_id)
            ->get();

        foreach($user as $d){
                $massg = 'Ada tagihan biaya baru bulan '.$request->bulan.' tahun '. $request->tahun.' ,silahkan dicek :)';
                Mail::send('email.pembayaranNotif', ['nama' => $d->nama, 'pesan' => $massg], function ($message) use ($d)
                {
                    $message->subject('Hi '.$d->nama.' ada tagihan baru');
                    $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
                    $message->to($d->email);
                });
            }
        Session::flash('success', 'Tagihan berhasil ditambahkan');
        return Redirect::back();
    }
}
