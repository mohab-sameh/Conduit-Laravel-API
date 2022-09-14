<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['author'];

    protected $guarded = [];


    // DEFINING RELATIONSHIPS HERE

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // DEFINING ACCESSORS HERE

    public function getJsonCommentAttribute()
    {
        return [
            'comment' => [
                'id' => $this->id,
                'created_at' => $this->created_at,
                'updatedAt' => $this->updated_at,
                'body' => $this->body,
                'author' => [
                    'username' => $this->author->username,
                    'bio' => $this->author->bio,
                    'image' => $this->author->image,
                    'following' => $this->author->followed_by_current_user,
                ],
            ]
        ];
    }
}
