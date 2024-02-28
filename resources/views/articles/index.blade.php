@extends('layout')
@section('content')
<h1>Cikkek</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="articlesContainer">
    @foreach($articles as $article)
    <div class="articlesBox">
        <div class="articleTitle">{{$article->title}}</div>
        <div class="articleSectionLabel"><b>Létrehozva: </b>{{$article->created_at}}</div>
        <div class="articleText">{{$article->article_text}}</div>
        <div class="articleTagLabel"><b>Tag-ek:</b></div>
        <div class="articleTag">
            @foreach ($article->tags as $singleTag)
                <span>{{ $singleTag->name }}</span>
            @endforeach
        </div>
        <div class="articleSectionLabel"><b>Hozzászólások:</b>
        
        <div class="commentForm">
            <form action="{{ route('comments.store') }}" method="post">
            @csrf
            <input type="hidden" name="article_id" value="{{$article->id}}">
            <input type="text" name="name" style="width:80%; background-color:lwhite; border: 1px solid lightgray; border-radius:4px; padding:3px;" placeholder="..itt írhatsz hozzászólást.">
            <button type="submit" class="button">Mehet</button>
            </form>
        </div>
        <div class="comments">
            @foreach ($article->comments as $singleComment)
                <div class="commentBubble">
                    <p class="commentText">
                        {{ $singleComment->name }}
                    </p>
                </div>
            @endforeach    
        </div>
        </div>
    </div>
    @endforeach
</div>

@endsection