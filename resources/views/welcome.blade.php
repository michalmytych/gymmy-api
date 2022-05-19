@extends('layouts.app')

@section('title')
- Welcome Page
@endsection

@section('content')
    <div style="width: 30%; margin: 0 auto; text-align: center; padding-top: 5rem;">
        <h1>Gymmy App Welcome Page</h1>
        <p>
            <a href="{{ route('docs') }}">Here</a> you can find docs.</p>
    </div>
@endsection
