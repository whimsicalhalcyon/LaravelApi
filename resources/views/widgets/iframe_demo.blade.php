@extends('layout.app')

@section('title', 'Виджеты для вставки')

@section('content')
    <div id="widget"></div>
@endsection

@push('scripts')
    @vite('resources/js/widget.js')
    <script>
        window.Laravel = {
            signedIn: {{ auth()->check() ? 'true' : 'false' }},
            user: @json(auth()->user())
        }
    </script>
@endpush
