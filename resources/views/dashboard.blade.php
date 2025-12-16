@extends('layouts.main')

@section('content')

<div class="max-w-3xl mx-auto mt-10 space-y-6">

    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <p class="text-sm">Olá,</p>
        <h2 class="text-lg font-semibold">{{ $user->name }}</h2>

        <div class="mt-4">
            <p class="text-sm opacity-80">Saldo disponível</p>
            <p class="text-2xl font-bold">
                R$ {{ number_format($wallet->balance, 2, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('deposit.show') }}"
           class="bg-white rounded-xl shadow p-6 flex flex-col items-center justify-center gap-2 hover:shadow-md transition">
            <span class="text-green-500 text-xl">+</span>
            <span class="font-medium">Depositar</span>
        </a>

        <a href="{{ route('transfer.show') }}"
           class="bg-green-500 text-white rounded-xl p-6 flex flex-col items-center justify-center gap-2 hover:bg-green-600 transition">
            <span class="text-xl">↗</span>
            <span class="font-medium">Transferir</span>
        </a>
    </div>

    <div>
        <h3 class="font-semibold mb-3">Histórico</h3>

        <div class="space-y-3">
            @forelse($transactions as $transaction)
                <div class="bg-white rounded-lg p-4 flex justify-between items-center border-2">
                    <div>
                        <p class="{{ $transaction->type_color }} font-bold">
                            {{ $transaction->type_label }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <p class="{{ $transaction->amount >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $transaction->amount >= 0 ? '+' : '-' }}
                        R$ {{ number_format(abs($transaction->amount), 2, ',', '.') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Nenhuma movimentação ainda.</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
