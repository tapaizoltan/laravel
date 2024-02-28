@extends('layout')
@section('content')
<h1>Új Tag</h1>

@error('name')
<div class="alert alert-warning">{{ $message }}</div>
@enderror

<form action="{{ route('tags.store') }}" method="post">
@csrf
<fieldset>
    <label for="title">Tag</label>
    <input type="text" name="name" id="name">
</fieldset>
<button type="submit">Rögzít</button>
</form>
@endsection