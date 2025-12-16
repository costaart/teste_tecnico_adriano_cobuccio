@extends('layouts.auth')


@section('content')

<div class="flex mb-6 bg-gray-100 rounded-lg p-1 text-sm">
    <a href="{{ route('login') }}" class="flex-1 text-center py-2 text-gray-500">
        Entrar
    </a>
    <span class="flex-1 text-center py-2 bg-white rounded-md font-medium">
        Cadastrar
    </span>
</div>

<h1 class="text-xl font-semibold">Criar conta</h1>
<p class="text-sm text-gray-500 mb-4">Preencha os dados para começar</p>

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
        <label class="text-xs font-bold">Nome completo</label>
        <input name="name" value="{{ old('name') }}"
               class="input" placeholder="Seu nome">
        @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-xs font-bold">E-mail</label>
        <input name="email" value="{{ old('email') }}"
               class="input" placeholder="exemplo@email.com">
        @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-xs font-bold">Senha</label>
        <input type="password" name="password" class="input">
        @error('password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-xs font-bold">Confirmar senha</label>
        <input type="password" name="password_confirmation" class="input">
    </div>

    <button class="w-full bg-green-500 text-white py-2 rounded-md">
        Criar conta →
    </button>
</form>

@endsection
