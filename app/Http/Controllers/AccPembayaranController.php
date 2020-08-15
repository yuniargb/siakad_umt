<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PDF;
use Mail;
class AccPembayaranController extends Controller
{
    public function index()
    {
        // $pembayaran = Pembayaran::with('siswa')->first();

        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')->get();
        return view('pembayaranAdmin.accPembayaran', compact('pembayaran'));
    }
    public function detail()
    {
        // $pembayaran = Pembayaran::with('siswa')->first();

        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')->get();
        return view('pembayaranAdmin.accPembayaran', compact('pembayaran'));
    }
    public function wajib()
    {
        // $pembayaran = Pembayaran::with('siswa')->first();

        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('tipe_pembayarans', 'pembayarans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->where('tipe_pembayarans.id', '=', 1)->get();
        return view('pembayaranAdmin.pembayaranWajib', compact('pembayaran'));
    }
    public function tambahan()
    {
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('tipe_pembayarans', 'pembayarans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->where('tipe_pembayarans.id', '<>', 1)->get();
        return view('pembayaranAdmin.pembayaranTambahan', compact('pembayaran'));
    }
    public function cetak($id)  
    {
        // $pembayaran = Pembayaran::with('siswa')->first();
        $decrypt = Crypt::decrypt($id);
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->where('pembayarans.id', $decrypt)->first();
        // return view('pembayaranAdmin.cetakPembayaran', compact('pembayaran'));
        
        $pdf = PDF::loadview('pembayaranAdmin.cetakPembayaran',compact('pembayaran'));
    	return $pdf->download('pembayaran');
    }
    public function update(Request $request,$id, $tipe,$tipebyr)
    {
        $decrypt = Crypt::decrypt($id);
        $bayar = Pembayaran::find($decrypt);

        $bayar->status = $tipe;

        $bayar->update();

        $siswa = DB::table('siswas')
            ->select('*')
            ->join('users', 'siswas.nis', '=', 'users.username')
            ->where('siswas.id',$bayar->siswa_id)
            ->first();
        $mass = $tipe == 1 ? 'Pembayaran berhasil di konfirmasi' : 'Pembayaran berhasil di tolak';
        $massg = $tipe == 1 ? 'Pembayaran anda berhasil di konfirmasi' : 'Pembayaran anda di tolak';
         Mail::send('email.pembayaranNotif', ['nama' => $siswa->nama, 'pesan' => $massg], function ($message) use ($siswa)
        {
            $message->subject('Verifikasi Pembayaran');
            $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
            $message->to($siswa->email);
        });


        
        Session::flash('success', $mass);
        
         return url()->previous();
    }
}
