<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return $user->profile;
    }

    public function follow(User $user)
    {
        $follow = Follow::factory()->create([
            'follower_id' => auth()->user()->id,
            'followed_id' => $user->id
        ]);

        return $user->profile;
    }

    public function unfollow(User $user)
    {
        $follow = Follow::where('follower_id', '=', auth()->user()->id)->where('followed_id', '=', $user->id)->delete();

        return $user->profile;
    }
}
