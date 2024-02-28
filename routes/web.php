<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\CommentsController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    
    dd(Article::with('tags')->find(1));
});

Route::resource('articles', ArticlesController::class);
Route::resource('tags', TagsController::class);
Route::resource('comments', CommentsController::class);