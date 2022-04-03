@extends('layouts._app')

@section('header')
    <h1>{{ $realization->realizationable->name }}</h1>
@endsection

@section('content')
    @if($realization->series->isEmpty())
        <h4>Pierwsza seria</h4>
    @else
        <h4>Kolejna seria</h4>
    @endif
    <h3>{{ $realization->realizationable->name }}</h3>
    <div class="horizontal-divider"></div>

    <ul>
        @foreach($realization->fresh()->series as $index => $series)
            <li><strong>{{ $index + 1 }} seria: </strong>{{ $series->repetitions_count }} powtórzeń przy obiążeniu <strong>{{ $series->weight_kg }}</strong> kg.</li>
        @endforeach
    </ul>

    <div>
        <form
                style="margin-top: 1.3rem;"
                method="POST"
                action="{{ route('realization.series.store', ['realization' => $realization]) }}">
            @csrf
            <label for="repetitions_count">Ilość powtórzeń:</label>
            <input id="repetitions_count" type="number" name="repetitions_count" value="0">
            <label for="weight_kg">Obciążenie (w kilogramach):</label>
            <input id="weight_kg" type="number" name="weight_kg" value="0" style="width: 90%">
            <span style="margin-left:5px; font-weight: bold;">kg</span>
            <input type="submit" value="Zapisz serię"/>
        </form>
    </div>

    <div class="horizontal-divider"></div>

    <form
            style="margin-top: 1.3rem;"
            method="POST"
            action="{{ route('realization.complete', ['realization' => $realization->id]) }}">
        @csrf
        <input type="submit" value="Zakończ ćwiczenie"/>
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

