<?php

namespace App\Http\Controllers;

use App\Nilai;
use App\Siswa;
use App\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mail;
class NilaiController extends Controller
{
    public function harian()
    {
        $mapel = MataPelajaran::all();
        $siswa = Siswa::all();
        $nilai = DB::table('nilais')
            ->select('*', 'nilais.id as id')
            ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'nilais.mata_pelajaran_id')
            ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
            ->where('nilais.tipe', 'harian')
            ->get();
        return view('nilai.nilaiharian', compact('nilai', 'siswa','mapel'));
    }
    public function ujian()
    {
        $mapel = MataPelajaran::all();
        $siswa = Siswa::all();
        $nilai = DB::table('nilais')
            ->select('*', 'nilais.id as id')
            ->join('mata_pelajarans', 'mata_pelajarans.id', '=', 'nilais.mata_pelajaran_id')
            ->join('siswas', 'siswas.id', '=', 'nilais.siswa_id')
            ->where('nilais.tipe', 'ujian')
            ->get();
        return view('nilai.nilaiujian', compact('nilai', 'siswa','mapel'));
    }
    public function raport()
    {
        $mapel = MataPelajaran::all();
        $siswa = Siswa::all();
        $nilai = DB::table('nilais')
            ->select('*', 'nilais.id as id')
            ->join('siswas', 'nilais.siswa_id', '=', 'siswas.id')
            ->join('mata_pelajarans', 'nilais.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->where('nilais.tipe', 'raport')
            ->get();
        return view('nilai.nilairaport', compact('nilai', 'siswa','mapel'));
    }

    public function store(Request $request)
    {
        $nilai = new Nilai;
        $nilai->nilai = $request->nilai;
        $nilai->semester = $request->semester;
        $nilai->tahun_ajaran = $request->tahun_ajaran;
        $nilai->siswa_id = $request->siswa_id;
        $nilai->tipe = $request->type;
        $nilai->mata_pelajaran_id = $request->mata_pelajaran_id;

        $nilai->save();

        $siswa = DB::table('siswas')
            ->select('*')
            ->join('users', 'siswas.nis', '=', 'users.username')
            ->where('siswas.id',$request->siswa_id)
            ->first();

        $mapel = MataPelajaran::find($request->mata_pelajaran_id)->first();
        $massg = 'Nilai anda di Mata Pelajaran '. $mapel->namamapel . ' telah ditambahkan';
        Mail::send('email.pembayaranNotif', ['nama' => $siswa->nama, 'pesan' => $massg], function ($message) use ($siswa)
        {
            $message->subject('Penilaian');
            $message->from('donotreply@ashiup.com', 'SMP MUHAMADIYAH 4 KOTA TANGERANG');
            $message->to($siswa->email);
        });
        Session::flash('success', 'Nilai berhasil ditambahkan');
        return Redirect::back();
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $nilai = Nilai::find($decrypt);
        return $nilai;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $nilai = Nilai::find($decrypt);

        $nilai->nilai = $request->nilai;
        $nilai->semester = $request->semester;
        $nilai->tahun_ajaran = $request->tahun_ajaran;
        $nilai->siswa_id = $request->siswa_id;
        $nilai->mata_pelajaran_id = $request->mata_pelajaran_id;

        $nilai->update();
        Session::flash('success', 'Nilai berhasil diubah');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $nilai = Nilai::find($decrypt);
        $nilai->delete();

        Session::flash('success', 'Nilai berhasil dihapus');
        return url()->previous();
    }
}
