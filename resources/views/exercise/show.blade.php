@extends('layouts._app')

@section('header')
    <h1>{{ $exercise->name }}</h1>
    @if(!empty($exercise->description))
        <h3>Opis</h3>
        <p>{{ $exercise->description }}</p>
    @else
        <em>Brak opisu</em>
    @endif
@endsection

