<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('role', 1)->get();
        return view('admin.admin', compact('admin'));
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->nama;
        $user->role = 1;
        $user->username = $request->username;
        $user->password = Hash::make('admin');
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        Session::flash('success', 'Data admin berhasil diinput');
        return Redirect::back();
    }

    public function edit($id)
    {
        $decrypt = Crypt::decrypt($id);
        $user = User::find($decrypt);
        return $user;
    }

    public function update(Request $request, $id)
    {
        $decrypt = Crypt::decrypt($id);
        $user = User::find($decrypt);
        $user->name = $request->nama;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->update();

        Session::flash('success', 'Data berhasil diupdate');
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
