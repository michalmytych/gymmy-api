@extends('layouts._app')

@section('header')
    <h1>Treningi</h1>
    <button
            class="shadowed"
            id="toggleFormButton">
        Dodaj
    </button>
@endsection

@section('content')
    <section>
        @if($realization)
            <h4>
                <span class="red-dot"></span>
                Trwa trening {{ $realization->training->name }}
                <a href="{{ route('training.realize', ['training' => $realization->training->id]) }}">
                    <i class="material-icons positioned-icon">play_arrow</i>Kontynuuj
                </a>
            </h4>
            <p id='trainingDuration'>
                <div class="skeleton" style="width: 86px; height: 19px" id="skeleton"></div>
            </p>
            <p id="runningTrainingStartedAt" style="visibility: hidden; height: 0; margin: 0; width: 0;">{{ $realization->time_started }}</p>
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
            class="shadowed"
            name="name"
            type="text"
            placeholder="Nazwa treningu"
        />
        <textarea
            lass="shadowed"
            name="description"
            placeholder="Opis"
        ></textarea>
        <select
            class="shadowed"
            name="exercises[ ]"
            multiple="multiple"
        >
            @foreach($exercises as $exercise)
                <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="shadowed-light">Zapisz</button>
    </form>

    <table class="table-body shadowed-light">
        <tbody>
            @foreach($trainings as $key => $training)
                <tr>
                    <td class="table-cell primary-cell">
                        <a href="{{ route('training.show', ['training' => $training->id]) }}">
                            <i class="material-icons positioned-icon">fitness_center</i>
                            {{ $training->name }}
                        </a>
                    </td>
                    <td class="table-cell action-cell">
                        @if($realization)
                            @if($realization->training->is($training))
                                <a href="{{ route('training.realize', ['training' => $realization->training->id]) }}">
                                    <i class="material-icons positioned-icon">play_arrow</i>
                                    <div class="mobile-hidden">Kontynuuj</div>
                                </a>
                            @else
                                <p style="color: rgb(108, 108, 108);">Realizuj</p>
                            @endif
                        @else
                            <a href="{{ route('training.realize', ['training' => $training->id]) }}">
                                <i class="material-icons positioned-icon">play_circle_outline</i>
                                <div class="mobile-hidden">Realizuj</div>
                            </a>
                        @endif
                    </td>
                    <td class="table-cell action-cell">
                        <a href="{{ route('training.update', ['training' => $training->id]) }}">
                            <i class="material-icons positioned-icon">create</i>
                            <div class="mobile-hidden">Edytuj</div>
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

            const skeleton = document.getElementById('skeleton')

            const allSeconds = Math.floor((Date.now() - Date.parse(_runningTrainingStartedAt)) / 1000)
            const hours = Math.floor(allSeconds / 3600)
            const minutes = Math.floor((allSeconds - hours * 3600) / 60)
            const seconds = Math.floor((allSeconds - hours * 3600) - minutes * 60)

            let finalDisplay = `${seconds}`

            if (seconds < 10) {
                finalDisplay = '0' + finalDisplay
            }

            if (minutes > 0) {
                finalDisplay = `${minutes}:` + finalDisplay
            } else {
                finalDisplay = `00:` + finalDisplay
            }

            if (minutes < 10) {
                finalDisplay = '0' + finalDisplay
            }

            if (hours > 0) {
                finalDisplay = `${hours}` + finalDisplay
            } else {
                finalDisplay = `00:` + finalDisplay
            }

            if (hours < 10 && hours > 0) {
                finalDisplay = '0' + finalDisplay
            }

            skeleton.style.display = 'none';
            trainingDurationDisplay.replaceChildren(finalDisplay);
        }

        if (trainingDurationDisplay) {
            window.setInterval(() => {
                updateDurationTime()
            }, 1000);
        }
    </script>
@endsection
