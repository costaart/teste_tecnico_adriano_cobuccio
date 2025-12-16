<?php

namespace App\Services\Wallet;

use App\DTO\Wallet\ReversalDTO;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Exceptions\Domain\AlreadyReversedException;
use App\Exceptions\Domain\UnauthorizedReversalException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReversalService
{
    public function execute(ReversalDTO $dto): void
    {
        DB::transaction(function () use ($dto) {

            $transaction = $dto->transaction;
            $actor = $dto->actor;

            if ($transaction->wallet->user_id !== $actor->id) {
                throw new UnauthorizedReversalException();
            }

            if ($transaction->status === TransactionStatus::REVERSED) {
                throw new AlreadyReversedException();
            }

            if ($transaction->group_id && $transaction->type !== TransactionType::TRANSFER_OUT) {
                throw new UnauthorizedReversalException();
            }

            if ($transaction->group_id) {
                $this->reverseTransfer($transaction);
                return;
            }

            $this->reverseSingleTransaction($transaction);
        });
    }

    private function reverseTransfer(Transaction $transaction): void
    {
        $transactions = Transaction::where('group_id', $transaction->group_id)->get();

        foreach ($transactions as $transaction) {

            if ($transaction->status === TransactionStatus::REVERSED) {
                throw new AlreadyReversedException();
            }

            $wallet = Wallet::where('id', $transaction->wallet_id)
                ->lockForUpdate()
                ->first();

            // cria transacao de reversao
            Transaction::create([
                'wallet_id'             => $wallet->id,
                'type'                  => TransactionType::REVERSAL,
                'amount'                => -$transaction->amount,
                'related_transaction_id'=> $transaction->id,
            ]);

            // ajusta saldo dps da reversao
            $this->applyReverseOperation($wallet, $transaction->amount);

            $transaction->update(['status' => TransactionStatus::REVERSED]);
        }
    }

    private function reverseSingleTransaction(Transaction $transaction): void
    {
        $wallet = Wallet::where('id', $transaction->wallet_id)
            ->lockForUpdate()
            ->first();

        Transaction::create([
            'wallet_id'             => $wallet->id,
            'type'                  => TransactionType::REVERSAL,
            'amount'                => -$transaction->amount,
            'related_transaction_id'=> $transaction->id,
        ]);

        // ajusta saldo dps da reversao
        $this->applyReverseOperation($wallet, $transaction->amount);

        $transaction->update(['status' => TransactionStatus::REVERSED]);
    }

    private function applyReverseOperation(Wallet $wallet, float $amount): void
    {
        if ($amount > 0) {
            $wallet->withdraw($amount);
        } else {
            $wallet->deposit(abs($amount));
        }
    }
}
