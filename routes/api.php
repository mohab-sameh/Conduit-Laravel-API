<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['namespace' => 'Api'], function(){
    Route::post('/users/login', [AuthController::class, 'login']);
    Route::post('/users', [AuthController::class, 'register']);


    Route::get('/user', [UserController::class, 'show'])->middleware('auth');
    Route::put('/user', [UserController::class, 'update'])->middleware('auth');

    Route::get('/profiles/{user:username}', [ProfileController::class, 'show']);
    Route::post('/profiles/{user:username}/follow', [ProfileController::class, 'follow'])->middleware('auth');
    Route::delete('/profiles/{user:username}/follow', [ProfileController::class, 'unfollow'])->middleware('auth');


    Route::get('/articles/feed', [FeedController::class, 'index'])->middleware('auth');

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show']);
    Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth');
    Route::put('/articles/{article:slug}', [ArticleController::class, 'update'])->middleware('auth');
    Route::delete('/articles/{article:slug}', [ArticleController::class, 'destroy'])->middleware('auth');




    Route::post('/articles/{article:slug}/comments', [CommentController::class, 'store'])->middleware('auth');
    Route::get('/articles/{article:slug}/comments', [CommentController::class, 'index']);
    Route::delete('/articles/{article:slug}/comments/{comment:id}', [CommentController::class, 'destroy'])->middleware('auth');

    Route::post('/articles/{article:slug}/favorite', [FavoriteController::class, 'add'])->middleware('auth');
    Route::delete('/articles/{article:slug}/favorite', [FavoriteController::class, 'remove'])->middleware('auth');

    Route::get('/tags', [TagController::class, 'index']);

});
