@extends('layout')
@section('content')
<h1>Új cikk</h1>

@error('title')
<div class="alert alert-warning">{{ $message }}</div>
@enderror

@error('article_text')
<div class="alert alert-warning">{{ $message }}</div>
@enderror

<form action="{{ route('articles.store') }}" method="post">
@csrf
<fieldset>
    <label for="title">Cikk címe</label>
    <input type="text" name="title" id="title">
</fieldset>
<fieldset>
    <label for="article_text">Cikk tartalma</label>
    <textarea name="article_text" id="article_text" rows="10" cols="30"></textarea>
</fieldset>
<button type="submit">Ment</button>
</form>
@endsection