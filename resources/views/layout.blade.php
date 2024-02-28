<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cikkek</title>
    <link rel="stylesheet" href="{{asset('style.css')}}">
</head>

<body>
<header>
    <nav>
        <a class="button" href="{{route ('articles.index')}}">Cikkek</a>
        <a class="button" href="{{route ('articles.create')}}">Új cikk létrehozása</a>
        <a class="button" href="{{route ('tags.index')}}">Tagek</a>
        <a class="button" href="{{route ('tags.create')}}">Új tag létrehozása</a>
        <a class="button" href="{{route ('comments.index')}}">Hozzászólások</a>
        <a class="button" href="{{route ('comments.create')}}">Új hozzászólás létrehozása</a>
    </nav>
</header>
<main>
    @yield('content')
</main>    
<footer></footer>
</body>
</html>