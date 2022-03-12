<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'gymmy') }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="logo">gymmy</div>

        <nav>
            <ul>
                <li>
                    <a href="{{ route('training.index') }}">Treningi</a>
                </li>
                <li>
                    <a href="{{ route('exercise.index') }}">Ćwiczenia</a>
                </li>
            </ul>
        </nav>

        <div>
            <header>
                <div>
                    @yield('header')
                </div>
                <div>
                    @if(isset($trainingNow) && $trainingNow)
                        <h3>Trwa trening</h3>
                    @endif
                </div>
            </header>

            <main>
                @yield('content')
            </main>
        </div>
        @yield('scripts')
    </body>
</html>
