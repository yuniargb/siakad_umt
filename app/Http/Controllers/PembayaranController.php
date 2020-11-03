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
        $pembayaran = DB::table('tagihans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->leftJoin('pembayarans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->leftJoin('siswas', 'siswas.id', '=', 'pembayarans.siswa_id')
            ->where('tagihans.kelas_id', $siswa->kelas_id)
            ->where('siswas.nis', auth()->user()->username)
            ->get();
        $tipe = TipePembayaran::all();
        return view('pembayaran.pembayaran', compact('pembayaran', 'siswa','tipe'));
    }
    public function tagihan()
    {
        $siswa = DB::table('siswas')
            ->select('*', 'siswas.id as ids', 'angkatans.tarifspp as tarif')
            ->join('angkatans', 'angkatans.id', '=', 'siswas.angkatan_id')
            ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
            ->where('siswas.nis', auth()->user()->username)->first();
        $tagihan = DB::table('tagihans')
            ->select(
                'tagihans.id as id',
                'tagihans.bulan',
                'tagihans.tahun',
                'tipe_pembayarans.namatipe',
                'tipe_pembayarans.id as tipe',
                'tipe_pembayarans.biaya'
                )
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->leftJoin(DB::raw('(select * from pembayarans where siswa_id = '.$siswa->ids.') as pembayarans'), 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->where('tagihans.kelas_id','=', $siswa->kelas_id)
            ->whereNull('pembayarans.tagihan_id')
            ->groupBy(
                'tagihans.id',
                'tagihans.bulan',
                'tagihans.tahun',
                'tipe_pembayarans.namatipe',
                'tipe_pembayarans.id',
                'tipe_pembayarans.biaya'
            )
            ->get();
       
        return view('pembayaran.tagihan', compact('tagihan', 'siswa'));
    }


    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Pembayaran::find($decrypt);
        return $ang;
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
        $pembayaran->tagihan_id = $request->tagihan_id;
        $pembayaran->no_rek = $request->no_rek;
        $pembayaran->jumlah = $request->jumlah;
        $pembayaran->tgl_transfer = $request->tgl;
        $pembayaran->siswa_id = $request->nis;
        $pembayaran->status = 0;
        $pembayaran->save();
        Session::flash('success', 'Pembayaran berhasil ditambahkan');
        return Redirect::back();
    }
    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $pembayaran = Pembayaran::find($decrypt);
        $resorce = $request->file('bukti');
        if($resorce){
            $name   = $resorce->getClientOriginalExtension();
            $newName = rand(100000, 1001238912) . "." . $name;
            \Image::make($resorce)->resize(300, 200);
            $resorce->move(\base_path() . "/public/images/paket", $newName);
        }else{
            $newName = $pembayaran->bukti;
        }

        
        $pembayaran->bukti = $newName;
        $pembayaran->atm = $request->atm;
        $pembayaran->no_rek = $request->no_rek;
        $pembayaran->jumlah = $request->jumlah;
        $pembayaran->tgl_transfer = $request->tgl;
        $pembayaran->pesan = '';
        $pembayaran->siswa_id = $request->nis;
        $pembayaran->status = 0;
        $pembayaran->save();


        Session::flash('success', 'Pembayaran berhasil diubah');
        return Redirect::back();
    }

    public function cetaksemua()
    {
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->where('siswas.nis', auth()->user()->username)->get();
        // return view('pembayaran.cetak', compact('pembayaran'));

        // $pegawai = Pegawai::all();
        $pdf = PDF::loadview('pembayaran.cetak',compact('pembayaran'));
    	return $pdf->download('pembayaran');
    }
}
