<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gymmy App @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            a {
                transition: 0.4s;
                color: green;
                text-decoration: none;
            }
            a:hover {
                font-weight: bolder;
            }
        </style>

        @yield('styles')
    </head>
    <body class="antialiased">
        @yield('content')
    </body>
</html>
