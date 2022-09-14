<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $with = ['comments', 'author'];

    protected $guarded = [];


    //SCOPES DEFINED HERE

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['tag'])) {
            $query->whereRelation('tags', 'name', request('tag'));
        }
        if (isset($filters['author'])) {
            $query->whereRelation('author', 'username', request('author'));
        }
        if (isset($filters['favorited'])) {
            $query->whereRelation('favorites', 'user_id', User::where('username',request('favorited'))->pluck('id')->first());
        }
        if (isset($filters['limit'])) {
            $query->take(request('limit'));
        }
        if (isset($filters['offset'])) {
            $query->offset(request('offset'));
        }
    }


    //RELATIONSHIPS DEFINED HERE

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }


    //ACCESSORS DEFINED HERE

    public function getFavoritedByCurrentUserAttribute()
    {
        if (Favorite::where('article_id', $this->id)->where('user_id', auth()?->user()->id)->count() > 0) {
            return true;
        }

        return false;
    }

    public function getFavoritedCountAttribute()
    {
        return Favorite::where('article_id', '=', $this->id)->count();
    }

    public function getTagsListAttribute()
    {
        return $this->tags->pluck('name')->toArray();
    }

    public function getJsonArticleAttribute()
    {
        return [
            'article' => [
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'body' => $this->body,
                'tagList' => $this->tags_list,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
                'favorited' => $this->favorited_by_current_user,
                'favoritesCount' => $this->favorited_count,
                'author' => [
                    'username' => $this->author->username,
                    'bio' => $this->author->bio,
                    'image' => $this->author->image,
                    'following' => $this->author->followed_by_current_user,
                ],
            ]
        ];
    }


    public function getJsonAllCommentsAttribute()
    {
        $commentsJson = [];
        foreach ($this->comments as $comment) {
            $commentsJson[] = $comment->json_comment['comment'];
        }

        return [
            'comments' => $commentsJson
        ];
    }


}
