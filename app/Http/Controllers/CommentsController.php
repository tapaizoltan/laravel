<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate(
            [
                'name'=>'min:3|max:255',
            ],
            [
                'name.min'=>'A kommentnek minimum 3 karakter hosszúnak kell lennie.', 
                'name.max'=>'A komment nem lehet hosszabb 255 karakternél.',
            ],
        );

        // így iratom fel a commentet
        $comment = new Comment();
        $comment->article_id = $request->article_id;
        $comment->name = $request->name;
        $comment->save();

        // -vagy így, rövidebben
        //unset($request['_token']);
        //$comment = Comment::create($request->all());

        return redirect()->route('articles.index')->with('success', 'A hozzászólást sikeresen létrhoztuk.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        return view('comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::find($id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name'=>'min:3|max:255',
            ],
            [
                'name.min'=>'A kommentnek minimum 3 karakter hosszúnak kell lennie.', 
                'name.max'=>'A komment nem lehet hosszabb 255 karakternél.',
            ],
        );

        $comment = Comment::find($id);
        $comment->title = $request->title;
        $comment->save();

        return redirect()->route('comments.index')->with('success', 'A komment sikeresen módosítva.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'A kommentet sikeresen töröltük.');
    }
}
