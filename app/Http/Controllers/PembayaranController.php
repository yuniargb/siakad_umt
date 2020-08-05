<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\TipePembayaran;
use App\Siswa;
use App\Angkatan;
use App\Pembayaran;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = DB::table('siswas')
            ->select('*', 'siswas.id as ids', 'angkatans.tarifspp as tarif')
            ->join('angkatans', 'angkatans.id', '=', 'siswas.angkatan_id')
            ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
            ->where('siswas.nis', auth()->user()->username)->first();
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('tipe_pembayarans', 'pembayarans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->where('siswas.nis', auth()->user()->username)->get();
        $tipe = TipePembayaran::all();
        return view('pembayaran.pembayaran', compact('pembayaran', 'siswa','tipe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $resorce = $request->file('bukti');
        $name   = $resorce->getClientOriginalExtension();
        $newName = rand(100000, 1001238912) . "." . $name;
        \Image::make($resorce)->resize(300, 200);
        $resorce->move(\base_path() . "/public/images/paket", $newName);


        $pembayaran = new Pembayaran;
        $pembayaran->bukti = $newName;
        $pembayaran->atm = $request->atm;
        $pembayaran->bulan = $request->bulan;
        $pembayaran->jumlah = $request->jumlah;
        $pembayaran->tgl_transfer = $request->tgl;
        $pembayaran->tipe_pembayaran_id = $request->tipepembayaran;
        $pembayaran->siswa_id = $request->nis;
        $pembayaran->status = 0;
        $pembayaran->save();
        Session::flash('success', 'Pembayaran berhasil ditambahkan');
        return Redirect::back();
    }

    public function cetaksemua()
    {
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->where('siswas.nis', auth()->user()->username)->get();
        // return view('pembayaran.cetak', compact('pembayaran'));

        // $pegawai = Pegawai::all();
        $pdf = PDF::loadview('pembayaran.cetak',compact('pembayaran'));
    	return $pdf->download('pembayaran');
    }
}
