<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginpost(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);
        if (Auth::attempt($request->only('username', 'password'))) {
            if(auth()->user()->role == 2){
                return redirect('/pembayaran');
            }else{
                return redirect('/accpembayaran');
            }
        }
        return redirect('/login')->withInput($request->only('username'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
