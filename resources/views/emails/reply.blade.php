@extends('layout.app')

@section('title', 'Отправленные  ')

@section('content')
    <div id="reply"></div>
@endsection

@push('scripts')
    @vite('resources/js/reply.js')
    <script>
        window.Laravel = {
            signedIn: {{ auth()->check() ? 'true' : 'false' }},
            user: @json(auth()->user()),
            messageId: {{ $messageId ?? 'null' }}
        }
    </script>
@endpush
