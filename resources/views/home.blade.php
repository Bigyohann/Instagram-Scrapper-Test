<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Instagram profile retriever</title>
        @viteReactRefresh
        @vite(['resources/js/app.tsx', 'resources/css/reset.css'])

    </head>
    <body class="antialiased">
        <div id="root"></div>
    </body>
</html>
