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

@if (session('success'))
    <div class="max-w-5xl mx-auto px-4 mt-6"
         x-data="{ show: true }"
         x-show="show"
         x-transition
         x-init="setTimeout(() => show = false, 2000)">
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div class="max-w-5xl mx-auto px-4 mt-6"
         x-data="{ show: true }"
         x-show="show"
         x-transition
         x-init="setTimeout(() => show = false, 2000)">
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    </div>
@endif


<main class="max-w-5xl mx-auto px-4 py-10">
    @yield('content')
</main>

@endsection
