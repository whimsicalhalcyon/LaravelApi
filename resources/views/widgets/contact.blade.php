@extends('layout.app')

@section('title', 'Виджеты')

@section('content')
    <div id="form"></div>
@endsection

@push('scripts')
    @vite('resources/js/contact.js')
    <script>
        window.Laravel = {
            signedIn: {{ auth()->check() ? 'true' : 'false' }},
            user: @json(auth()->user())
        }
    </script>
@endpush
