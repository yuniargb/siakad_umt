<?php

namespace App\Http\Controllers;

use App\TipePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TipePembayaranController extends Controller
{
    public function index()
    {
        $tipepembayaran = TipePembayaran::all();
        return view('tipepembayaran.tipepembayaran', compact('tipepembayaran'));
    }

    public function store(Request $request)
    {
        $ang = new TipePembayaran;
        $ang->namatipe = $request->namatipe;
        $ang->biaya = $request->biaya;

        $ang->save();
        Session::flash('success', 'Tipe Pembayaran berhasil ditambahkan');
        return Redirect::back();
    }

    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = TipePembayaran::find($decrypt);
        return $ang;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = TipePembayaran::find($decrypt);
         $ang->namatipe = $request->namatipe;
         $ang->biaya = $request->biaya;

        $ang->update();
        Session::flash('success', 'Tipe Pembayaran berhasil diubah');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = TipePembayaran::find($decrypt);
        $ang->delete();

        Session::flash('success', 'Tipe Pembayaran berhasil dihapus');
        return '/tipepembayaran';
    }
}
