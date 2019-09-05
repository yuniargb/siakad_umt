<?php

namespace App\Http\Controllers;

use App\Angkatan;
use App\Http\Requests\SiswaRequest;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $angkatan = Angkatan::orderBy('angkatan', 'asc')->get();
        $siswa = Siswa::all();
        return view('siswa.siswa', compact('siswa', 'angkatan'));
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
    public function store(SiswaRequest $request)
    {
        $siswa = new Siswa;
        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tgl_lahir = $request->tgl_lahir;
        $siswa->jk = $request->jk;
        $siswa->agama = $request->agama;
        $siswa->alamat = $request->alamat;
        $siswa->angkatan_id = $request->angkatan;

        $siswa->save();
        Session::flash('success', 'Siswa berhasil ditambahkan');
        return Redirect::back();
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
        $siswa = Siswa::find($decrypt);
        return $siswa;
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
        $siswa = Siswa::find($decrypt);

        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tgl_lahir = $request->tgl_lahir;
        $siswa->jk = $request->jk;
        $siswa->agama = $request->agama;
        $siswa->alamat = $request->alamat;
        $siswa->angkatan_id = $request->angkatan;

        $siswa->update();
        Session::flash('success', 'Siswa berhasil diedit');
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
        $siswa = Siswa::find($decrypt);
        $siswa->delete();

        Session::flash('success', 'Siswa berhasil dihapus');
        return '/siswa';
    }
}
