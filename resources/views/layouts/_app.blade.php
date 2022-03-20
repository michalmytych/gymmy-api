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
        <div>
            <div class="logo">gymmy</div>

            <nav id="nav" style="position: relative; top: -3.5rem;">
                <ul>
                    <li>
                        <a href="{{ route('training.index') }}">Treningi</a>
                    </li>
                    <li>
                        <a href="{{ route('exercise.index') }}">Ćwiczenia</a>
                    </li>
                </ul>
                <div id="lineBox" class="lines_box">
                    <div class="line line_top"></div>
                    <div class="line line_middle"></div>
                    <div class="line line_bottom"></div>
                </div>
            </nav>

            <div class="page-container">
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
        </div>

        <script>
            const lineBox = document.getElementById('lineBox')

            lineBox.addEventListener('click', function(e) {
                const nav = document.getElementById('nav')

                if (nav.style.top === '-3.5rem') {
                    nav.animate([
                        { top: '-3.5rem' },
                        { top: '-0.2rem' }
                    ], {
                        duration: 150,
                        fill: 'forwards'
                    })
                }

                console.log(nav.style.top)

                if (nav.style.top === '-0.2rem') {
                    nav.animate([
                        { top: '-0.2rem' },
                        { top: '-3.5rem' }
                    ], {
                        duration: 500,
                        fill: 'forwards'
                    })
                }
            })
        </script>
        @yield('scripts')
    </body>
</html>
