<?php

namespace App\Services\Wallet;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Exceptions\Domain\AlreadyReversedException;
use Illuminate\Support\Facades\DB;

class ReversalService
{
    public function execute(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction) {

            if ($transaction->status === 'reversed') {
                throw new AlreadyReversedException();
            }

            // caso seja transferencia
            if ($transaction->group_id) {
                $this->reverseTransfer($transaction);
                return;
            }

            // caso seja deposito
            $this->reverseSingleTransaction($transaction);
        });
    }

    private function reverseTransfer(Transaction $transaction): void
    {
        $transactions = Transaction::where('group_id', $transaction->group_id)->get();

        foreach ($transactions as $transaction) {

            if ($transaction->status === 'reversed') {
                throw new AlreadyReversedException();
            }

            $wallet = Wallet::where('id', $transaction->wallet_id)
                ->lockForUpdate()
                ->first();

            // cria transacao de reversao
            Transaction::create([
                'wallet_id'             => $wallet->id,
                'type'                  => 'reversal',
                'amount'                => -$transaction->amount,
                'related_transaction_id'=> $transaction->id,
            ]);

            // ajusta saldo
            if ($transaction->amount > 0) {
                $wallet->decrement('balance', $transaction->amount);
            } else {
                $wallet->increment('balance', abs($transaction->amount));
            }

            $transaction->update(['status' => 'reversed']);
        }
    }

    private function reverseSingleTransaction(Transaction $transaction): void
    {
        $wallet = Wallet::where('id', $transaction->wallet_id)
            ->lockForUpdate()
            ->first();

        Transaction::create([
            'wallet_id'             => $wallet->id,
            'type'                  => 'reversal',
            'amount'                => -$transaction->amount,
            'related_transaction_id'=> $transaction->id,
        ]);

        // ajusta saldo dps da reversao
        if ($transaction->amount > 0) {
            $wallet->decrement('balance', $transaction->amount);
        } else {
            $wallet->increment('balance', abs($transaction->amount));
        }

        $transaction->update(['status' => 'reversed']);
    }
}
