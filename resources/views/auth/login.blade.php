@extends('layouts.auth')

@section('content')

<div class="flex mb-6 bg-gray-100 rounded-lg p-1 text-sm">
    <span class="flex-1 text-center py-2 bg-white rounded-md font-medium">
        Entrar
    </span>
    <a href="{{ route('register') }}" class="flex-1 text-center py-2 text-gray-500">
        Cadastrar
    </a>
</div>

<h1 class="text-xl font-semibold">Bem-vindo de volta!</h1>
<p class="text-sm text-gray-500 mb-4">Entre para acessar o sistema</p>

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
        <label class="text-xs font-bold">E-mail</label>
        <input name="email" value="{{ old('email') }}"
               class="input" placeholder="seu@email.com">
    </div>

    <div>
        <label class="text-xs font-bold">Senha</label>
        <input type="password" name="password" class="input">
    </div>

    @if(session('error'))
        <p class="text-red-500 text-sm">{{ session('error') }}</p>
    @endif

    <button class="w-full bg-green-500 text-white py-2 rounded-md">
        Entrar →
    </button>
</form>

@endsection
