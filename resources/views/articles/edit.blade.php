@extends('layout')
@section('content')
<h1>Cikk szerkesztése</h1>

@error('title')
<div class="alert alert-warning">{{ $message }}</div>
@enderror

@error('article_text')
<div class="alert alert-warning">{{ $message }}</div>
@enderror

<form action="{{ route('articles.update', $article->id) }}" method="post">
@csrf
@method('PUT')
<fieldset>
    <label for="title">Cikk címe</label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}">
</fieldset>
<fieldset>
    <label for="article_text">Cikk tartalma</label>
    <textarea name="article_text" id="article_text" rows="10" cols="30">{{ old('article_text', $article->article_text) }}</textarea>
</fieldset>
<fieldset>
    <label for="article_tag">Tag</label>
    <textarea name="article_tag" id="article_tag" rows="10" cols="30">{{ implode(',',$article->tags->pluck('name')->toArray()) }}</textarea>
</fieldset>
<button type="submit">Ment</button>
</form>
@endsection