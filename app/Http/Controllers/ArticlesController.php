<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Comment;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$articles = Article::all();
        $articles = Article::query()
        ->where('published', 'LIKE', 1) // ->where('name', 'LIKE', "%{$search}%") <---- ha visszakapjuk egy formtól a $search válozót mondjuk egy kereső mező által
        ->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'=>'required|min:3|max:255',
                'article_text'=>'required',
            ],
            [
                'title.required'=>'A cím nem lehet üres.',
                'title.min'=>'A címnek minimum 3 karakter hosszúnak kell lennie.', 
                'title.max'=>'A cím nem lehet hosszabb 255 karakternél.',
                'article_text.required'=>'A cikk nem lehet üres.',
            ],
        );

        /*
        $article = new Article();
        $article->title = $request->title;
        $article->article_text = $request->article_text;
        $article->save();
*/
        $article = Article::create();
        $article->tag()->sync((array)$request->input('tag'));

        return redirect()->route('articles.index')->with('success', 'A cikket sikeresen létrehoztuk.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'title'=>'required|min:3|max:255',
                'article_text'=>'required',
            ],
            [
                'title.required'=>'A cím nem lehet üres.',
                'title.min'=>'A címnek minimum 3 karakter hosszúnak kell lennie.', 
                'title.max'=>'A cím nem lehet hosszabb 255 karakternél.',
                'article_text.required'=>'A cikk nem lehet üres.',
            ],
        );

        $article = Article::find($id);
        $article->title = $request->title;
        $article->article_text = $request->article_text;
        $article->save();

        $tags = [];

        foreach(explode(',',$request->article_tag) as $tag) {
            $tags[] = new Tag(['name' =>  $tag]);
        }

        $article->tags()->saveMany($tags);
        /*
        $article->tags()->saveMany([
            new Tag(['name' => 'A new comment.']),
            new Comment(['message' => 'Another new comment.']),
        ]);
        */
        return redirect()->route('articles.index')->with('success', 'A cikk sikeresen módosítva.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'A cikket sikeresen töröltük.');
    }
}