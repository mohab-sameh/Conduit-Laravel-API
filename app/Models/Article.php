<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $with = ['comments'];

    protected $guarded = [];

    public function scopeFilter($query, $filters)
    {

        if (isset($filters['tag'])) {
            // TO BE IMPLEMENTED
        }
        if (isset($filters['author'])) {
            $query->whereRelation('author', 'username', request('author'));
        }
        if (isset($filters['favorited'])) {
            // TO BE IMPLEMENTED
        }
        if (isset($filters['limit'])) {
            $query->take(request('limit'));
        }
        if (isset($filters['offset'])) {
            $query->offset(request('offset'));
        }

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
