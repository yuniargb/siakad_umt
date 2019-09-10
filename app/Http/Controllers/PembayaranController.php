<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Siswa;
use App\Angkatan;
use App\Pembayaran;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa= DB::table('siswas')
        ->select('*','siswas.id as ids','angkatans.tarifspp as tarif')
        ->join('angkatans', 'angkatans.id', '=', 'siswas.angkatan_id')
        ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
        ->where('siswas.nis',auth()->user()->username)->first();
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->where('siswas.nis',auth()->user()->username)->get();
        return view('pembayaran.pembayaran', compact('pembayaran', 'siswa'));
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
        $resorce->move(\base_path() . "/public/images/paket", $newName);


        $pembayaran = new Pembayaran;
        $pembayaran->bukti = $newName;
        $pembayaran->atm = $request->atm;
        $pembayaran->bulan = $request->bulan;
        $pembayaran->jumlah = $request->jumlah;
        $pembayaran->tgl_transfer = $request->tgl;
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
            ->where('siswas.nis',auth()->user()->username)->get();
        return view('pembayaran.cetak', compact('pembayaran'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $kelas = Pembayaran::find($decrypt);
        return $kelas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $kelas = Kelas::find($decrypt);

        $kelas->namakelas = $request->kelas;

        $kelas->update();
        Session::flash('success', 'Kelas berhasil diedit');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $pembayaran = Pembayaran::find($decrypt);
        $pembayaran->delete();

        Session::flash('success', 'Pembayaran berhasil dihapus');
        return '/pembayaran';
    }
}
