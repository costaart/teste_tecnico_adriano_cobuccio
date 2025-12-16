<?php

namespace App\DTO\Wallet;

use App\Models\User;

final class TransferDTO
{
    public function __construct(
        public readonly User $from,
        public readonly User $to,
        public readonly float $amount,
    ) {}
}
