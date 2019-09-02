<?php

namespace App\Http\Controllers;

use App\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AngkatanController extends Controller
{
    public function index()
    {
        $angkatan = Angkatan::all();
        return view('angkatan.angkatan', compact('angkatan'));
    }

    public function store(Request $request)
    {
        $ang = new Angkatan;
        $ang->angkatan = $request->tahunMasuk;
        $ang->tarifspp = $request->tarif;

        $ang->save();
        Session::flash('success', 'Spp berhasil ditambahkan');
        return Redirect::back();
    }

    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Angkatan::find($decrypt);
        return $ang;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Angkatan::find($decrypt);
        $ang->angkatan = $request->tahunMasuk;
        $ang->tarifspp = $request->tarif;

        $ang->update();
        Session::flash('success', 'Spp berhasil diubah');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Angkatan::find($decrypt);
        $ang->delete();

        Session::flash('success', 'Spp berhasil dihapus');
        return '/spp';
    }
}
