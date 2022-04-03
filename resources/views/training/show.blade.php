@extends('layouts._app')

@section('header')
    <h1>{{ $training->name }}</h1>
    @if(!empty($training->description))
        <h3>Opis</h3>
        <p>{{ $training->description }}</p>
    @else
        <em>Brak opisu</em>
    @endif
@endsection

@section('content')
    <div class="horizontal-divider"></div>
    <ul>
        @foreach ($training->exercises as $exercise)
            <li>
                <i class="material-icons positioned-icon primary-color">fitness_center</i>
                <span>{{ $exercise->name }}</span>
            </li>
        @endforeach
    </ul>
@endsection

