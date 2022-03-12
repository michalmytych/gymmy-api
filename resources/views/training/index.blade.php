@extends('layouts._app')

@section('header')
    <h1>Treningi</h1>
    <button id="toggleFormButton">
        Dodaj
    </button>
@endsection

@section('content')
    <section>
        @if($realization)
            <h4>Trwa trening {{ $realization->training->name }}</h4>
            <p id='trainingDuration'>-</p>
            <p id="runningTrainingStartedAt" style="visibility: hidden; height: 0; margin: 0; width: 0;">{{ $realization->time_started }}</p>
            <a href="{{ route('training.realize', ['training' => $realization->training->id]) }}">
                Kontynuuj
            </a>
            <form method="POST" action="{{ route('realization.complete', ['realization' => $realization->id]) }}">
                @csrf
                <input type="submit" placeholder="Nazwa treningu" value="Zakończ"/>
            </form>
        @endif
    </section>
    <form
        id="storeForm"
        style="display: none;"
        method="POST"
        action="{{ route('training.store') }}">
        @csrf
        <input
            name="name"
            type="text"
            placeholder="Nazwa treningu"
        />
        <textarea
            name="description"
            placeholder="Opis"
        ></textarea>
        <select
            name="exercises[ ]"
            multiple="multiple"
        >
            @foreach($exercises as $exercise)
                <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
            @endforeach
        </select>
        <button type="submit">Zapisz</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Realizacja</th>
                <th>Edycja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trainings as $training)
                <tr>
                    <td>
                        <a href="{{ route('training.show', ['training' => $training->id]) }}">
                            {{ $training->name }}
                        </a>
                    </td>
                    <td>
                        @if($realization)
                            @if($realization->training->is($training))
                                <a href="{{ route('training.realize', ['training' => $realization->training->id]) }}">
                                    Kontynuuj
                                </a>
                            @else
                                <p style="color: rgb(108, 108, 108);">Realizuj</p>
                            @endif
                        @else
                            <a href="{{ route('training.realize', ['training' => $training->id]) }}">
                                Realizuj
                            </a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('training.update', ['training' => $training->id]) }}">
                            Edytuj
                        </a>
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
            const form = document.getElementById('storeForm');

            if (form.style.display == 'none') {
                toggleFormButton.innerHTML = 'anuluj'
                form.style.display = '';
        } else {
                toggleFormButton.innerHTML = 'dodaj'
                form.style.display = 'none';
            }
        })

        const runningTrainingStartedAt = document.getElementById('runningTrainingStartedAt')
        const trainingDurationDisplay = document.getElementById('trainingDuration')

        function updateDurationTime()
        {
            let _runningTrainingStartedAt = runningTrainingStartedAt.innerHTML

            const allSeconds = Math.floor((Date.now() - Date.parse(_runningTrainingStartedAt)) / 1000)
            const hours = Math.floor(allSeconds / 3600)
            const minutes = Math.floor((allSeconds - hours * 3600) / 60)
            const seconds = Math.floor((allSeconds - hours * 3600) - minutes * 60)

            trainingDurationDisplay.innerHTML = `${hours} godzin ${minutes} minut ${seconds} sekund`
        }

        if (trainingDurationDisplay) {
            window.setInterval(() => {
                updateDurationTime()
            }, 1000);
        }
    </script>
@endsection
