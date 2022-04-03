@extends('layouts._app')

@section('header')
    <h1>Edycja ćwiczenia {{ $exercise->name }}</h1>
@endsection

@section('content')
    <form
            method="POST"
            action="{{ route('exercise.update', ['exercise' => $exercise->id]) }}">
        @csrf
        <input type="hidden" name="_method" value="put"/>
        <input
                name="name"
                type="text"
                placeholder="Nazwa ćwiczenia"
                value="{{ $exercise->name }}"
        />
        <textarea
                name="description"
                placeholder="Opis"
        >{{ $exercise->description }}
        </textarea>
        <select
                name="muscle_groups[ ]"
                multiple="multiple"
        >
            @foreach($muscle_groups as $muscleGroup)
                <option
                        value="{{ $muscleGroup->id }}"
                        @if($exercise->muscleGroups->contains($muscleGroup))
                            selected
                        @endif
                >
                    {{ $muscleGroup->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Zapisz</button>
    </form>
@endsection
