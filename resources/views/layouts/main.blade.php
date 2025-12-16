@extends('layouts.app')

@section('body')

<header class="bg-white border-b">
    <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="font-semibold text-green-600">
            <a href="{{ route('dashboard') }}">AppFinanceiro</a>
            
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-gray-500 hover:text-gray-700">
                Sair
            </button>
        </form>
    </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-10">
    @yield('content')
</main>

@endsection
