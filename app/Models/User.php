<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // ACCESSORS DEFINED HERE

    public function getJsonUserAttribute()
    {
        $token = Auth::login($this);
        return response()->json([
            'user' => [
                'email' => $this->email,
                'token' => $token,
                'username' => $this->username,
                'bio' => $this->bio,
                'image' => $this->image,
            ]
        ]);
    }


    public function getProfileAttribute()
    {
        return [
            'profile' => [
                'username' => $this->username,
                'bio' => $this->bio,
                'image' => $this->image,
                'following' => $this->followed_by_current_user,

            ]
        ];
    }

    public function getFavoriteArticlesIdsAttribute()
    {
        return Favorite::where('user_id', '=', $this->id)->pluck('article_id')->toArray();
    }

    public function getFavoriteArticlesAttribute()
    {
        return Article::whereIn('id', $this->favorite_articles_ids)->get();
    }

    public function getFavoriteArticlesCountAttribute()
    {
        return Favorite::where('user_id', '=', $this->id)->count();
    }

    public function getFollowedByCurrentUserAttribute()
    {
        if (Follow::where('follower_id', auth()?->user()->id)->where('followed_id', $this->id)->count() > 0) {
            return true;
        }

        return false;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}
