@extends('layouts._app')

@section('header')
    <h1>Ćwiczenia</h1>
    <button id="toggleFormButton">
        Dodaj
    </button>
@endsection

@section('content')
    <form id="form" style="display: none;" method="POST" action="{{ route('exercise.store') }}">
        @csrf
        <input name="name" type="text" placeholder="Nazwa ćwiczenia">
        <br>
        <textarea name="description" placeholder="Opis ćwiczenia">
        <br>
        <input type="submit" value="Zapisz">
    </form>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Nazwa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exercises as $exercise)
                <tr>
                    <td>
                        {{ $exercise->name }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        const toggleFormButton = document.getElementById('toggleFormButton');

        toggleFormButton.addEventListener('click', function() {
            const form = document.getElementById('form');

            if (form.style.display == 'none') {
                toggleFormButton.innerHTML = 'anuluj'
                form.style.display = '';
            } else {
                toggleFormButton.innerHTML = 'dodaj'
                form.style.display = 'none';
            }
        })
    </script>
@endsection
