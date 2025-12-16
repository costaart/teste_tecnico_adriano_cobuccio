@extends('layouts.main')

@section('content')

<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-xl font-semibold mb-6">Transferir</h1>

    <form method="POST" action="{{ route('transfer.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">
                Email do destinatário
            </label>

            <input name="email" placeholder="email@exemplo.com" class="input" value="{{ old('email') }}"/>

            @error('email')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">
                Valor da transferência
            </label>

            <input name="amount" type="number" step="0.01" placeholder="R$ 0,00" class="input" value="{{ old('amount') }}" />

            <p class="text-xs text-gray-400 mt-1">
                Saldo disponível: R$ {{ number_format(auth()->user()->wallet->balance, 2, ',', '.') }}
            </p>

            @error('amount')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-medium hover:bg-green-600">
            Confirmar transferência
        </button>   
    </form>
</div>

@endsection
