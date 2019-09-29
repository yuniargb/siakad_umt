<?php

namespace App\Http\Controllers;

use App\Angkatan;
use App\Http\Requests\SiswaRequest;
use App\Kelas;
use App\Siswa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        $kelas = Kelas::all();
        return view('siswa.siswa', compact('siswa', 'angkatan', 'kelas'));
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

        $rules = [
            'nis' => 'unique:siswas,nis'
        ];
        $message = [
            'unique' => 'Nis Sudah Ada!',
        ];
        $this->validate($request, $rules, $message);

        // insert into siswa
        $siswa = new Siswa;
        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tgl_lahir = $request->tgl_lahir;
        $siswa->jk = $request->jk;
        $siswa->agama = $request->agama;
        $siswa->alamat = $request->alamat;
        $siswa->user_id = 1;
        $siswa->angkatan_id = $request->angkatan;
        $siswa->kelas_id = $request->kelas;
        $siswa->save();

        // insert into user
        $pass = date('dmy', strtotime($request->tgl_lahir));

        $user = new User;
        $user->name = $request->nama;
        $user->role = 2;
        $user->username = $request->nis;
        $user->email_verified_at = now();
        $user->password = Hash::make($pass);
        $user->remember_token = Str::random(10);
        $user->save();

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

    public function pass($id)
    {
        $decrypt = Crypt::decrypt($id);
        $siswa = Siswa::find($decrypt);
        $pass = date('dmy', strtotime($siswa->tgl_lahir));

        $user = User::where('username', $siswa->nis)->first();
        $user->password = Hash::make($pass);

        $user->update();
        Session::flash('success', 'Kata sandi berhasil diatur ulang');
        return Redirect::back();

        // return $siswa;
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
        $siswa->kelas_id = $request->kelas;

        $siswa->update();
        Session::flash('Sukses', 'Siswa berhasil diubah');
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

        Session::flash('Sukses', 'Siswa berhasil dihapus');
        return '/siswa';
    }
}
