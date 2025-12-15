<?php

namespace App\Exceptions\Domain;
use DomainException;


class InsufficientFundsException extends \DomainException
{
    protected $message = 'Saldo insuficiente para realizar a transferência.';
}
