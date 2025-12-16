<?php

namespace App\Services\Wallet;

use App\DTOs\Wallet\DepositDTO;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DepositService
{
    public function execute(DepositDTO $dto): Transaction
    {
        return DB::transaction(function () use ($dto) {

            // concorrencia
            $wallet = $dto->user->wallet()->lockForUpdate()->first();

            $transaction = Transaction::create([
                'wallet_id' => $wallet->id,
                'type'      => TransactionType::DEPOSIT,
                'amount'    => $dto->amount,
                'status'    => TransactionStatus::POSTED,
            ]);

            $wallet->deposit($dto->amount);

            return $transaction;
        });
    }
}
