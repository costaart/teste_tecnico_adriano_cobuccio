<?php

namespace App\DTOs\Wallet;

use App\Models\User;

final class DepositDTO
{
    public function __construct(
        public readonly User $user,
        public readonly float $amount,
    ) {}
}