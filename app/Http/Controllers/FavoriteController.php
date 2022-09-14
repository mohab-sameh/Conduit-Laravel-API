<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function add(Article $article)
    {
        Favorite::factory()->create([
            'user_id' => auth()?->user()->id,
            'article_id' => $article->id
        ]);

        return $article->json_article;
    }

    public function remove(Article $article)
    {
        $favorite = Favorite::where('article_id', $article->id)->where('user_id', auth()?->user()->id)->delete();

        return $article->json_article;
    }
}
