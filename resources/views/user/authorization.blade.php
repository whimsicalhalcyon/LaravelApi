@extends('layout.app')

@section('title', 'Авторизация')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-slate-400 to-gray-200">

        <div class="w-[600px] bg-white rounded-xl p-8">

            <h1 class="text-2xl text-center mb-2 font-semibold">Авторизация</h1>

            <form method="POST" action="{{route('user.auth')}}" class="flex flex-col">
                @csrf
                @method('post')
                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded-md outline-none">
                </div>

                <div class="mb-6">
                    <label class="block text-sm mb-1">Пароль</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded-md outline-none">
                </div>

                <button class="w-full bg-slate-400 text-white p-2 rounded-md">Войти</button>

            </form>

            <p class="text-center text-sm mt-6 text-gray-500">
                Нет аккаунта?
                <a href="{{route('user.registration')}}" class="text-shadow-slate-800 underline">Создать</a>
            </p>

        </div>
    </div>
@endsection
