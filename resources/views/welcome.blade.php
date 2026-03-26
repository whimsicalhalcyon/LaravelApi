@extends('layout.app')

@section('title', 'Главная')

@section('content')
    <div id="app">
        <script>
            window.Laravel = {
                user: @json(auth()->user()),
                signedIn: @json(Auth::check())
            }
        </script>
    </div>
@endsection
