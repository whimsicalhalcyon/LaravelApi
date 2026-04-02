@extends('layout.app')

@section('title', 'Доступные сайты')

@section('content')
    <div id="cors"></div>
@endsection

@push('scripts')
    @vite('resources/js/cors.js')
    <script>
        window.Laravel = {
            signedIn: {{ auth()->check() ? 'true' : 'false' }},
            user: @json(auth()->user()),
            messageId: {{ $messageId ?? 'null' }}
        }
    </script>
@endpush
