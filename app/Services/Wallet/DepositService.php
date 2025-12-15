<?php

namespace App\Services\Wallet;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DepositService
{
    public function execute(User $user, float $amount): Transaction
    {
        return DB::transaction(function () use ($user, $amount) {

            // concorrencia
            $wallet = $user->wallet()->lockForUpdate()->first();

            $transaction = Transaction::create([
                'wallet_id' => $wallet->id,
                'type'      => 'deposit',
                'amount'    => $amount,
                'status'    => 'posted',
            ]);

            $wallet->balance += $amount;
            $wallet->save();

            return $transaction;
        });
    }
}
