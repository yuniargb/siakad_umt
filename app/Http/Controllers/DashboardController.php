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

        switch ($user->role) {
            case '2':
                $user = Siswa::find($id);
                break;

            default:
                $user = User::find($id);
                break;
        }

        return view('user.user', compact('user'));
    }
}
