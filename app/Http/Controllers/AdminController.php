<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('role', '!=', 2)->get();
        return view('admin.admin', compact('admin'));
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->nama;
        $user->role = $request->role;
        $user->username = $request->username;
        $user->password = Hash::make('password');
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        Session::flash('success', 'Data admin berhasil diinput');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $decrypt = Crypt::decrypt($id);
        $user = User::find($decrypt);
        $user->delete();
        return '/admin';
    }
}
