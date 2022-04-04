@extends('layouts._app')

@section('header')
    <h1>Realizacje</h1>
@endsection

@section('content')
    <table class="table-body shadowed-light">
        <tbody>
            @foreach($realizations as $realization)
{{--                {{dd($realization->toArray())}}--}}
                <tr class="table-row">
                    <td class="table-cell">
                        {{ $realization->realizationable->name }}
                    </td>
                    <td class="table-cell">
                        {{ $realization->time_started }}
                    </td>
                    <td class="table-cell">
                        {{ $realization->time_ended ?? '-' }}
                    </td>
                    <td class="table-cell">
                        <ul>
                        @foreach($realization->childrenRealizations as $child)
                            <li>
                                {{ $child->realizationable->name }}
                            </li>
                        @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
