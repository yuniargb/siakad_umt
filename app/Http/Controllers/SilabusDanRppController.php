<?php

namespace App\Http\Controllers;

use App\SilabusDanRpp;
use App\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SilabusDanRppController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::all();
        $sdp = DB::table('silabus_dan_rpps')
            ->select('*','silabus_dan_rpps.id as id')
            ->join('mata_pelajarans', 'silabus_dan_rpps.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->get();
        return view('rppdansilabus.rppdansilabus', compact('mapel','sdp'));

    }

    public function store(Request $request)
    {
        $ang = new SilabusDanRpp;
        $ang->kompetensi_dasar = $request->kompetensi_dasar;
        $ang->indikator_pencapaian_kompetensi = $request->indikator_pencapaian_kompetensi;
        $ang->materi_pembelajaran = $request->materi_pembelajaran;
        $ang->kegiatan_pembelajaran = $request->kegiatan_pembelajaran;
        $ang->ppr = $request->ppr;
        $ang->media = $request->media;
        $ang->alokasi_waktu = $request->alokasi_waktu;
        $ang->semester = $request->semester;
        $ang->kelas = $request->kelas;
        $ang->tahun_ajaran = $request->tahun_ajaran;
        $ang->mata_pelajaran_id = $request->mata_pelajaran_id;

        $ang->save();
        Session::flash('success', 'RPP berhasil ditambahkan');
        return Redirect::back();
    }

    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = SilabusDanRpp::find($decrypt);
        return $ang;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = SilabusDanRpp::find($decrypt);
        $ang->kompetensi_dasar = $request->kompetensi_dasar;
        $ang->indikator_pencapaian_kompetensi = $request->indikator_pencapaian_kompetensi;
        $ang->materi_pembelajaran = $request->materi_pembelajaran;
        $ang->kegiatan_pembelajaran = $request->kegiatan_pembelajaran;
        $ang->ppr = $request->ppr;
        $ang->media = $request->media;
        $ang->alokasi_waktu = $request->alokasi_waktu;
        $ang->semester = $request->semester;
        $ang->kelas = $request->kelas;
        $ang->tahun_ajaran = $request->tahun_ajaran;
        $ang->mata_pelajaran_id = $request->mata_pelajaran_id;

        $ang->update();
        Session::flash('success', 'RPP berhasil diubah');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = SilabusDanRpp::find($decrypt);
        $ang->delete();

        Session::flash('success', 'RPP berhasil dihapus');
        return '/rppdansilabus';
    }
}
