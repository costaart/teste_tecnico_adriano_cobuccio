<?php

namespace App\Enums;

enum TransactionType: string
{
    case DEPOSIT = 'deposit';
    case TRANSFER_IN = 'transfer_in';
    case TRANSFER_OUT = 'transfer_out';
    case REVERSAL = 'reversal';

    public function label(): string
    {
        return match ($this) {
            self::DEPOSIT      => 'Depósito',
            self::TRANSFER_IN  => 'Transferência recebida',
            self::TRANSFER_OUT => 'Transferência enviada',
            self::REVERSAL     => 'Reversão',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DEPOSIT      => 'text-green-600',
            self::TRANSFER_IN  => 'text-blue-600',
            self::TRANSFER_OUT => 'text-red-500',
            self::REVERSAL     => 'text-orange-500',
        };
    }
}
