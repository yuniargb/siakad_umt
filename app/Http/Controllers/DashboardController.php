<?php

namespace App\Http\Controllers;

use App\Siswa;
use App\User;
use App\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $logo = Logo::find(1);
        return view('dashboard',compact('logo'));
    }

    public function user()
    {
        $id = auth()->user()->id;
        $user = User::find($id);

        if ($user->role == 2) {
            // $user = User::with('siswa')->where('username', auth()->user()->username)->first();

            $user = DB::table('users')
                ->select('*', 'siswas.id as ids', 'angkatans.tarifspp as tarif')
                ->join('siswas', 'users.username', '=', 'siswas.nis')
                ->join('angkatans', 'angkatans.id', '=', 'siswas.angkatan_id')
                ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
                ->where('siswas.nis', auth()->user()->username)->first();
        } else {
            $user = User::find($id);
        }


        return view('user.user', compact('user'));
    }
}
