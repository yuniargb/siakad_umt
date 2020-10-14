<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuruRequest;
use App\Guru;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    public function index()
    {
        
        $guru = DB::table('gurus')
            ->select('gurus.*','users.email')
            ->join('users', 'gurus.nip', '=', 'users.username')
            ->get();
        return view('guru.guru', compact('guru'));
    }

    public function store(GuruRequest $request)
    {

        $rules = [
            'nip' => 'unique:gurus,nip',
            'no_kartu' => 'unique:users,no_kartu'
        ];
        $message = [
            'unique' => ':attribute Sudah Ada!'
        ];
       
        $this->validate($request, $rules, $message);

        // insert into guru
        $guru = new Guru;
        $guru->nip = $request->nip;
        $guru->nama = $request->nama;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tgl_lahir = $request->tgl_lahir;
        $guru->jk = $request->jk;
        $guru->agama = $request->agama;
        $guru->alamat = $request->alamat;
        $guru->user_id = 1;
        $guru->save();

        // insert into user
        $pass = date('dmy', strtotime($request->tgl_lahir));

        $user = new User;
        $user->name = $request->nama;
        $user->role = 7;
        $user->username = $request->nip;
        $user->no_kartu = $request->no_kartu;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = Hash::make($pass);
        $user->remember_token = Str::random(10);
        $user->save();

        Session::flash('success', 'Guru berhasil ditambahkan');
        return Redirect::back();
    }

    public function pass($id)
    {
        $decrypt = Crypt::decrypt($id);
        $guru = Guru::find($decrypt);
        $pass = date('dmy', strtotime($guru->tgl_lahir));

        $user = User::where('username', $guru->nip)->first();
        $user->password = Hash::make($pass);

        $user->update();
        
        Session::flash('success', 'Kata sandi berhasil diatur ulang');
        return Redirect::back();

        // return $siswa;
    }
    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $guru = DB::table('gurus')
            ->select('*')
            ->join('users', 'gurus.nip', '=', 'users.username')
            ->where('gurus.id',$decrypt)
            ->first();
        return json_encode($guru);
    }
    public function update(Request $request, $id)
    {
        

        $decrypt = Crypt::decrypt($id);
        $guru = Guru::find($decrypt);

        $guru->nip = $request->nip;
        $guru->nama = $request->nama;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tgl_lahir = $request->tgl_lahir;
        $guru->jk = $request->jk;
        $guru->agama = $request->agama;
        $guru->alamat = $request->alamat;

        $guru->update();

        $user = User::where('username', $request->nip)->first();
        $user->email = $request->email;
        $user->no_kartu = $request->no_kartu;
        $user->name = $request->nama;
        $user->remember_token = Str::random(10);
        $user->update();
        Session::flash('success', 'Guru berhasil diubah');
        return Redirect::back();
    }
    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $guru = Guru::find($decrypt);
        $guru->delete();

        $user = User::where('username', $guru->nip)->first();
        $user->delete();

        Session::flash('success', 'Guru berhasil dihapus');
        return '/guru';
    }
}
