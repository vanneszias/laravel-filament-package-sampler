<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }}</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: sans-serif; margin: 2rem; color: #1a1a1a; }
        h1 { font-size: 2rem; margin-bottom: 1rem; }
        .intro { font-size: 1.1rem; color: #555; margin-bottom: 2rem; }
    </style>
</head>
<body>
    <h1>{{ $page->title }}</h1>

    @if ($page->intro)
        <p class="intro">{{ $page->intro }}</p>
    @endif

    <div class="prose content">
        <x-flexible-content-blocks :page="$page"/>
    </div>
</body>
</html>
