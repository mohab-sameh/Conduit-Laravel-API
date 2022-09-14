<?php

namespace App\Http\Controllers;


use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->filter(request(['tag', 'author', 'favorited', 'limit', 'offset']))->get();

        $jsonArticles = [];
        foreach ($articles as $article){
            $jsonArticles[] = $article->json_article['article'];
        }

        return [
            'articles' => $jsonArticles
            ];
    }

    public function show(Article $article)
    {
        return $article->json_article;
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'body' => 'string|required'
        ]);
        $attributes['user_id'] = auth()->user()->id;

        $article = Article::factory()->create($attributes);


        foreach ($request['tagList'] as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        }


        return $article->json_article;
    }

    public function update(Article $article)
    {
        $attributes = request()->validate([
            'title' => 'string',
            'description' => 'string',
            'body' => 'string',
        ]);

        $article->title = request('title') ?? $article->title;
        $article->slug = request('title') ? Str::slug(request('title')) : $article->slug;
        $article->description = request('description') ?? $article->description;
        $article->body = request('body') ?? $article->body;
        $article->save();

        return $article->json_article;
    }

    public function destroy(Article $article)
    {
        $article->delete();
    }


}
