<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show(){
        return auth()->user();
    }

    public function update(){
        $userData = request()->json()->all();
        $userData = $userData['user'];


        if(isset($userData['username'])){
            $user = DB::table('users')->where('username', $userData['username'])->first();
        }
        elseif(isset($userData['email'])){
            $user = DB::table('users')->where('email', $userData['email'])->first();
        }else{
            return "No User Found";
        }



        return $user;
    }
}
