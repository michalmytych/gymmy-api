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
        </style>
    </head>
    <body class="antialiased">
        <div style="width: 30%; margin: 0 auto; text-align: center; padding-top: 5rem;">
            <h1>Gymmy App Welcome Page</h1>
            <p>
                <a href="{{ route('docs') }}">Here</a> you can find docs.</p>
        </div>
    </body>
</html>
