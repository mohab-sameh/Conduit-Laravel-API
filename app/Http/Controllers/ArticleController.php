<?php

namespace App\Http\Controllers;


use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $posts = Article::latest()->filter(request(['tag', 'author', 'favorited', 'limit', 'offset']))->get();


        return $posts;
    }

    public function show()
    {
        //
    }

    public function store()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }


}
