<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }}</title>
    @if ($page->excerpt)
        <meta name="description" content="{{ $page->excerpt }}">
    @endif
</head>
<body>
    <main>
        <h1>{{ $page->title }}</h1>
        {!! $html !!}
    </main>
</body>
</html>
