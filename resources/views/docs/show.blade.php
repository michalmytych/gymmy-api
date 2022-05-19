@extends('layouts.app')

@section('title')
- Docs Page
@endsection

@section('styles')
    <style>
        code {
            background: rgb(232, 232, 232);
            box-shadow: 2px 2px 5px  rgba(57, 57, 57, 0.277);
            padding: 0.2rem;
            border-radius: 4px;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div style="width:60%; margin: 0 auto; text-align: left; padding-top: 5rem;">
        <a href="{{ route('welcome') }}">Go back</a>
        <x-markdown>
            {{ $markdown }}
        </x-markdown>
        <hr style="margin-top: 2rem; margin-bottom: 5rem;">
        <a style="margin-bottom: 5rem;" href="{{ route('welcome') }}">Go back</a>
    </div>
@endsection
