<?php

namespace App\Http\Controllers;

use App\User;
use App\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        $logo = Logo::first();

        return view('auth.login', compact('logo'));
    }

    public function loginpost(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);
        $user = DB::table('users')
            ->select('*', 'users.id as id')
            ->leftJoin('gurus', 'users.username', '=', 'gurus.nip')
            ->leftJoin('kelas', 'gurus.id', '=', 'kelas.guru_id')
            ->where('users.username',$request->username)->first();
        // var_dump(Hash::check($request->password, $user->password));
        if (Auth::attempt(array('username' => $request->username, 'password' => $request->password))) {
            if (auth()->user()->role == 2) {
                return redirect('/');
            } else if (auth()->user()->role == 3) {
                return redirect('/');
            } else {
                return redirect('/');
            }
        }else{
            Session::flash('failed', 'password salah');
            return redirect('/login')->withInput($request->only(['username','password']));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
