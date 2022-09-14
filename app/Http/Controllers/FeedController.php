<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Follow;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $followed_users = Follow::where('follower_id', auth()->user()->id)->get();
        $followed_users = $followed_users->pluck('followed_id');

        $articles = Article::latest()->filter(request(['limit', 'offset']))->whereIn('user_id', $followed_users)->get();
        $jsonArticles = [];
        foreach ($articles as $article){
            $jsonArticles[] = $article->json_article['article'];
        }

        return [
            'articles' => $jsonArticles
            ];

        //return $posts;
    }
}
