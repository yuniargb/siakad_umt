<?php

namespace App\Http\Controllers;

use App\Jadwal;
use App\Kelas;
use App\Guru;
use App\MataPelajaran;
use App\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $angkatan = Angkatan::all();
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::all();
        $jadwal = DB::table('jadwals')
            ->select('*', 'jadwals.id as id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('gurus', 'jadwals.guru_id', '=', 'gurus.id')
            ->join('mata_pelajarans', 'jadwals.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->get();
            // return view('rppdansilabus.rppdansilabus', compact('mapel'));
        return view('jadwal.jadwal', compact('jadwal','angkatan','kelas','mapel','guru'));
    }

    public function store(Request $request)
    {
        $ang = new Jadwal;
        $ang->hari = $request->hari;
        $ang->semester = $request->semester;
        $ang->jam = $request->jam;
        $ang->guru_id = $request->guru_id;
        $ang->kelas_id = $request->kelas_id;
        $ang->mata_pelajaran_id = $request->mata_pelajaran_id;
        $ang->tahun_ajaran = $request->tahun_ajaran;

        $ang->save();
        Session::flash('success', 'Jadwal berhasil ditambahkan');
        return Redirect::back();
    }

    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Jadwal::find($decrypt);
        return $ang;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Jadwal::find($decrypt);
        $ang->hari = $request->hari;
        $ang->jam = $request->jam;
        $ang->semester = $request->semester;
        $ang->guru_id = $request->guru_id;
        $ang->kelas_id = $request->kelas_id;
        $ang->mata_pelajaran_id = $request->mata_pelajaran_id;
        $ang->tahun_ajaran = $request->tahun_ajaran;

        $ang->update();
        Session::flash('success', 'Jadwal berhasil diubah');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $ang = Jadwal::find($decrypt);
        $ang->delete();

        Session::flash('success', 'Jadwal berhasil dihapus');
        return '/jadwal';
    }
}
