<?php

namespace App\Exceptions\Domain;

use RuntimeException;

class InvalidAmountException extends RuntimeException
{
    protected $message = 'O valor informado é inválido.';
}
