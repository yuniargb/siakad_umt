<?php

namespace App\Http\Controllers;
use App\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class AccPembayaranController extends Controller
{
    public function index()
    {
        // $pembayaran = Pembayaran::with('siswa')->first();
        
        $pembayaran = DB::table('pembayarans')
                    ->select('*', 'pembayarans.id as id_p')
                    ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')->get();
        return view('pembayaranAdmin.accPembayaran', compact('pembayaran'));
    }
    public function cetak($id)
    {
        // $pembayaran = Pembayaran::with('siswa')->first();
        $decrypt = Crypt::decrypt($id);
        $pembayaran = DB::table('pembayarans')
                    ->select('*', 'pembayarans.id as id_p')
                    ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
                    ->where('pembayarans.id', $decrypt)->first();
        return view('pembayaranAdmin.cetakPembayaran', compact('pembayaran'));
    }
    public function update($id,$tipe)
    {
        $decrypt = Crypt::decrypt($id);
        $bayar = Pembayaran::find($decrypt);

        $bayar->status = $tipe;

        $bayar->update();

        $mass = $tipe == 1 ? 'Pembayaran berhasil di konfirmasi' : 'Pembayaran berhasil di tolak';
        Session::flash('success', $mass);
        return '/accpembayaran';
    }
}
