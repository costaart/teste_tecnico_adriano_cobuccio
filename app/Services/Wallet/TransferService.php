<?php

namespace App\Services\Wallet;

use App\Enums\TransactionType;
use App\Models\User;
use App\Models\Transaction;
use App\Exceptions\Domain\InsufficientFundsException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransferService
{
    public function execute(User $from, User $to, float $amount): void
    {
        DB::transaction(function () use ($from, $to, $amount) {

            if ($from->id === $to->id) {
                throw new \DomainException('Não é possível transferir para si mesmo.');
            }

            // evita concorrencia (dnv)
            $fromWallet = $from->wallet()->lockForUpdate()->first();
            $toWallet = $to->wallet()->lockForUpdate()->first();

            if ($fromWallet->balance < $amount) {
                throw new InsufficientFundsException();
            }

            $groupId = Str::uuid();

            Transaction::create([
                'wallet_id' => $fromWallet->id,
                'type'      => TransactionType::TRANSFER_OUT,
                'amount'    => -$amount,
                'group_id'  => $groupId,
            ]);

            Transaction::create([
                'wallet_id' => $toWallet->id,
                'type'      => TransactionType::TRANSFER_IN,
                'amount'    => $amount,
                'group_id'  => $groupId,
            ]);

            $fromWallet->decrement('balance', $amount);
            $toWallet->increment('balance', $amount);
        });
    }
}
