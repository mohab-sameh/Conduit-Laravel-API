<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {

        $attributes = $request->validate([
            'body' => 'string|required'
        ]);

        $comment = Comment::factory()->create([
            'user_id' => $request->user()->id,
            'article_id' => $article->id,
            'body' => $request['body']
        ]);

        return $comment->json_comment;
    }

    public function index(Request $request, Article $article)
    {
        return $article->json_all_comments;
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return 'comment deleted successfully';
    }


}
