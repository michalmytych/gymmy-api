@extends('layouts._app')

@section('header')
    <h1>{{ $realization->realizationable->name }}</h1>
@endsection

@section('content')
{{--    @todo - dodac zrealizowane ćwiczenia   --}}
    @if($realization->realizationable->exercises->isEmpty())
        <p>Trening nie zawiera ćwiczeń.</p>
    @else
        <h4>Realizuj ćwiczenie:</h4>
        <form
                style="margin-top: 1.3rem;"
                method="POST"
                action="{{ route('exercise.realize', ['realization' => $realization->id]) }}">
            @csrf
            <select
                    class="shadowed"
                    name="exercise"
            >
                @foreach($realization->realizationable->exercises as $exercise)
                    <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                @endforeach
            </select>
        <input type="submit" value="Realizuj ćwiczenie"/>
        </form>
    @endif

    <div class="horizontal-divider"></div>

    <form
            style="margin-top: 1.3rem;"
            method="POST"
            action="{{ route('realization.complete', ['realization' => $realization->id]) }}">
        @csrf
        <input type="submit" value="Zakończ"/>
    </form>

{{--        @foreach ($realization->exercises as $exercise)--}}
{{--            <div>--}}
{{--                <strong>{{ $exercise->name }}</strong>--}}
{{--            </div>--}}
{{--            <ul>--}}
{{--                <form--}}
{{--                    method="POST"--}}
{{--                    action="{{ route('training.store-realize', ['training' => $realization->training, 'exercise' => $exercise->id]) }}"--}}
{{--                >--}}
{{--                    @csrf--}}
{{--                    <ul>--}}
{{--                        @foreach ($exercise->series as $_series)--}}
{{--                            <li>--}}
{{--                                <strong>Powtórzenia: </strong>{{ $_series->repetitions_count }} powtórzeń--}}
{{--                                <strong>Przerwa: </strong>{{ $_series->break_duration }} sekund--}}
{{--                                <strong>Obciązenie: </strong>{{ $_series->weight }} kg--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                    <input--}}
{{--                            type="number"--}}
{{--                            name="repetitions_count"--}}
{{--                            placeholder="Ilość powtórzeń">--}}
{{--                    <br>--}}
{{--                    <input--}}
{{--                            type="number"--}}
{{--                            name="break_duration"--}}
{{--                            placeholder="Długość przerwy w sekundach">--}}
{{--                    <br>--}}
{{--                    <input--}}
{{--                            type="number"--}}
{{--                            name="weight"--}}
{{--                            placeholder="Obciązenie">--}}
{{--                    <br>--}}
{{--                    <input type="submit" value="Zapisz">--}}
{{--                </form>--}}
{{--            </ul>--}}
{{--        @endforeach--}}
@endsection

