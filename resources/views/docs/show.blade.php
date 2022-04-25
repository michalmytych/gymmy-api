<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gymmy App Welcome Page</title>

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
            code {
                background: rgb(232, 232, 232);
                box-shadow: 2px 2px 5px  rgba(57, 57, 57, 0.277);
                padding: 0.2rem;
                border-radius: 4px;
                display: block;
            }
        </style>
    </head>
    <body class="antialiased">
        <div style="width:60%; margin: 0 auto; text-align: left; padding-top: 5rem;">
            <a href="{{ route('welcome') }}">Go back</a>
            <x-markdown>
                {{ $markdown }}
            </x-markdown>
            <hr style="margin-top: 2rem; margin-bottom: 5rem;">
            <a style="margin-bottom: 5rem;" href="{{ route('welcome') }}">Go back</a>
        </div>
    </body>
</html>
