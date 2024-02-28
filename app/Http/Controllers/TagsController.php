<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'=>'required|min:3|max:255',
            ],
            [
                'name.required'=>'A tag címe nem lehet üres.',
                'name.min'=>'A tagnek minimum 3 karakter hosszúnak kell lennie.', 
                'name.max'=>'A tag nem lehet hosszabb 255 karakternél.',
            ],
        );

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();
        return redirect()->route('articles.index')->with('success', 'A taget sikeresen létrehoztuk.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::find($id);
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = Tag::find($id);
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name'=>'required|min:3|max:255',
            ],
            [
                'name.required'=>'A tag címe nem lehet üres.',
                'name.min'=>'A tagek minimum 3 karakter hosszúnak kell lennie.', 
                'name.max'=>'A tag nem lehet hosszabb 255 karakternél.',
            ],
        );

        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->save();
        return redirect()->route('tags.index')->with('success', 'A tag sikeresen módosítva.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'A taget sikeresen töröltük.');
    }
}
