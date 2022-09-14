<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show()
    {
        return auth()->user()->json_user;
    }


    public function update()
    {
        $user = auth()->user();

        $attributes = request()->validate([
            'email' => 'email',
            'username' => 'string',
            'password' => 'string',
            'bio' => 'string'
        ]);

        $user->email = request()->email ?? $user->email;
        $user->username = request()->username ?? $user->username;
        $user->password = request()->password ?? $user->password;
        $user->image = request()->image ?? $user->image;
        $user->bio = request()->bio ?? $user->bio;
        $user->save();

        return $user->json_user;
    }
}
