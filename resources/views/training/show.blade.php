<h1>{{ $training->name }}</h1>
<p>{{ $training->description }}</p>
<ul>
    @foreach ($training->exercises as $exercise)
        <li>
            <p>{{ $exercise->name }}</p>
        </li>
    @endforeach
</ul>
