<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class KelasController extends Controller
{
   
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.kelas', compact('kelas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $kelas = new Kelas;
        $kelas->namakelas = $request->kelas;

        $kelas->save();
        Session::flash('success', 'Kelas berhasil ditambahkan');
        return Redirect::back();
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $kelas = Kelas::find($decrypt);
        return $kelas;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $kelas = Kelas::find($decrypt);

        $kelas->namakelas = $request->kelas;

        $kelas->update();
        Session::flash('success', 'Kelas berhasil diubah');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $kelas = Kelas::find($decrypt);
        $kelas->delete();

        Session::flash('success', 'Kelas berhasil dihapus');
        return '/kelas';
    }
}
