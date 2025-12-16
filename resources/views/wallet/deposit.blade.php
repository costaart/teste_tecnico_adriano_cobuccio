@extends('layouts.main')

@section('content')

<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-xl font-semibold mb-6">Depositar</h1>

    <form method="POST" action="{{ route('deposit.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">
                Valor do depósito
            </label>

            <input name="amount" type="number" step="0.01" placeholder="R$ 0,00" class="input" value="{{ old('amount') }}"/>

            @error('amount')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-medium hover:bg-green-600">
            Confirmar depósito
        </button>
    </form>
</div>

@endsection
