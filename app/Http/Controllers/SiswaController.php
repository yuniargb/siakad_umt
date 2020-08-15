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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index()
    {
        $angkatan = Angkatan::orderBy('angkatan', 'asc')->get();
        
        $siswa = DB::table('siswas')
            ->select('siswas.nis','siswas.nama','siswas.id','kelas.namaKelas','angkatans.angkatan','users.email')
            ->join('users', 'siswas.nis', '=', 'users.username')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->join('angkatans', 'siswas.angkatan_id', '=', 'angkatans.id')
            ->get();
        $kelas = Kelas::all();
        // dd($siswa);
        return view('siswa.siswa', compact('siswa', 'angkatan', 'kelas'));
    }
    public function getSiswa($kelas){
        $siswa = DB::table('siswas')
            ->select('*', 'users.id as id')
            ->join('users', 'siswas.nis', '=', 'users.username')
            ->where('role','=',2)
            ->where('siswas.kelas_id','=',$kelas)->get();
        return $siswa;
    }
    public function getPembayaran($id){
        $decrypt = Crypt::decrypt($id);
        $pembayaran = DB::table('pembayarans')
            ->select('*', 'pembayarans.id as id_p')
            ->join('tagihans', 'tagihans.id', '=', 'pembayarans.tagihan_id')
            ->join('tipe_pembayarans', 'tagihans.tipe_pembayaran_id', '=', 'tipe_pembayarans.id')
            ->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
            ->join('angkatans', 'siswas.angkatan_id', '=', 'angkatans.id')
            ->where('siswas.id',$decrypt)
            ->get();
        return $pembayaran;
    }
    public function store(SiswaRequest $request)
    {

        $rules = [
            'nis' => 'unique:siswas,nis',
            'no_kartu' => 'unique:users,no_kartu'
        ];
        $message = [
            'unique' => ':attribute Sudah Ada!',
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

        $siswa->nama_panggilan =  $request->nama_panggilan; 
        $siswa->nama_ayah =  $request->nama_ayah;
        $siswa->agama_ayah =  $request->agama_ayah; 
        $siswa->nama_ibu =  $request->nama_ibu;
        $siswa->agama_ibu =  $request->agama_ibu; 
        $siswa->pekerjaan_ayah =  $request->pekerjaan_ayah; 
        $siswa->pekerjaan_ibu =  $request->pekerjaan_ibu;
        $siswa->penghasilan_ayah =  $request->penghasilan_ayah; 
        $siswa->penghasilan_ibu =  $request->penghasilan_ibu; 
        $siswa->no_telp =  $request->no_telp; 
        $siswa->no_telp_ayah =  $request->no_telp_ayah; 
        $siswa->no_telp_ibu =  $request->no_telp_ibu; 
        $siswa->anak_ke =  $request->anak_ke;
        $siswa->alamat_wali = $request->alamat_wali;


        $siswa->save();

        // insert into user
        $pass = date('dmy', strtotime($request->tgl_lahir));

        $user = new User;
        $user->name = $request->nama;
        $user->role = 2;
        $user->username = $request->nis;
        $user->email = $request->email;
        $user->no_kartu = $request->no_kartu;
        $user->email_verified_at = now();
        $user->password = Hash::make($pass);
        $user->remember_token = Str::random(10);
        $user->save();

        Session::flash('success', 'Siswa berhasil ditambahkan');
        return Redirect::back();
    }

    public function pass($id)
    {
        $decrypt = Crypt::decrypt($id);
        $siswa = Siswa::find($decrypt);
        $pass = date('dmy', strtotime($siswa->tgl_lahir));
        $pass = Hash::make($pass);
        $user = User::where('username', $siswa->nis)->first();
        $user->password = $pass;

        $user->update();
        
        Session::flash('success', 'Kata sandi berhasil diatur ulang  ---'.$decrypt.'------------------- ' . $pass . '----------' .  $siswa->nis);
        return Redirect::back();

        // return $siswa;
    }
    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        // $siswa = Siswa::find($decrypt);
         $siswa = DB::table('siswas')
            ->select('*')
            ->join('users', 'siswas.nis', '=', 'users.username')
            ->where('siswas.id',$decrypt)
            ->first();
        return json_encode($siswa);
    }
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
        
        $siswa->nama_panggilan =  $request->nama_panggilan; 
        $siswa->nama_ayah =  $request->nama_ayah;
        $siswa->agama_ayah =  $request->agama_ayah; 
        $siswa->nama_ibu =  $request->nama_ibu;
        $siswa->agama_ibu =  $request->agama_ibu; 
        $siswa->pekerjaan_ayah =  $request->pekerjaan_ayah; 
        $siswa->pekerjaan_ibu =  $request->pekerjaan_ibu;
        $siswa->penghasilan_ayah =  $request->penghasilan_ayah; 
        $siswa->penghasilan_ibu =  $request->penghasilan_ibu; 
        $siswa->no_telp =  $request->no_telp; 
        $siswa->no_telp_ayah =  $request->no_telp_ayah; 
        $siswa->no_telp_ibu =  $request->no_telp_ibu; 
        $siswa->anak_ke =  $request->anak_ke;
        $siswa->alamat_wali = $request->alamat_wali;

        $siswa->update();

        $user = User::where('username', $request->nis)->first();
        $user->email = $request->email;
        $user->no_kartu = $request->no_kartu;
        $user->remember_token = Str::random(10);
        $user->update();
        Session::flash('success', 'Siswa berhasil diubah');
        return Redirect::back();
    }
    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $siswa = Siswa::find($decrypt);
        $siswa->delete();

        Session::flash('success', 'Siswa berhasil dihapus');
        return '/siswa';
    }
}
