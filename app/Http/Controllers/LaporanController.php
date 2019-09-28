<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use App\Kelas;
use App\Exports\BulanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function bulan()
    {
        $kelas = Kelas::all();
        return view('laporan.lapBulan', compact('kelas'));
    }

    public function cetakbulan(Request $request)
    {

        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->where('pembayarans.bulan', $request->bulan)
            ->where('siswas.kelas_id', $request->kelas)->get();
        $bulan = $request->bulan;
        return view('laporan.cetakBulan', compact('pembayaran', 'bulan'));
    }
    // public function cetakbulan(Request $request)
    // {
    //     $pembayaran = DB::table('pembayarans')
    //                 ->select('*', 'pembayarans.id as id_p')
    //                 ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
    //                 ->where('pembayarans.bulan', $request->bulan)->get();
    //     // return $pembayaran;
    // 	return Excel::download($pembayaran, 'pembayaran.xlsx');
    // }
}
