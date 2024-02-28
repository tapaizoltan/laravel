@extends('layout')
@section('content')

<h1>{{$article->title}} című cikk részletei</h1>

<p>Cikk tartalma: {{$article->article_text}}</p>

@endsection