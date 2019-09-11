<?php

namespace App\Http\Controllers;

use App\Siswa;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function user()
    {
        $id = auth()->user()->id;
        $user = User::find($id);

        if ($user->role == 2) {
            $user = Siswa::find($id);
        } else {
            $user = User::find($id);
        }

        var_dump($user);
        // return view('user.user', compact('user'));
    }
}
