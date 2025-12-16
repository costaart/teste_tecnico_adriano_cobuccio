<?php

namespace App\DTOs\Wallet;

use App\Models\User;
use App\Models\Transaction;

final class ReversalDTO
{
    public function __construct(
        public readonly Transaction $transaction,
        public readonly User $actor,
    ) {}
}
