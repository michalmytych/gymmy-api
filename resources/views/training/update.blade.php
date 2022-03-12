@extends('layouts._app')

@section('header')
    <h1>Edycja treningu {{ $training->name }}</h1>
@endsection

@section('content')
    <form
            method="POST"
            action="{{ route('training.update', ['training' => $training->id]) }}">
        @csrf
        <input type="hidden" name="_method" value="put" />
        <input
                name="name"
                type="text"
                placeholder="Nazwa treningu"
                value="{{ $training->name }}"
        />
        <textarea
                name="description"
                placeholder="Opis"
        >{{ $training->description }}
        </textarea>
        <select
                name="exercises[ ]"
                multiple="multiple"
        >
            @foreach($exercises as $exercise)
                <option
                    value="{{ $exercise->id }}"
                    @if($training->exercises()->where('exercise_id', $exercise->getKey())->exists())
                        selected
                    @endif
                >
                    {{ $exercise->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Zapisz</button>
    </form>
@endsection
