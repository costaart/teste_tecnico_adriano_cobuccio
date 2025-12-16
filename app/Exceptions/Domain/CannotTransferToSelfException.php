<?php

namespace App\Exceptions\Domain;

use RuntimeException;

class CannotTransferToSelfException extends RuntimeException
{
    protected $message = 'Não é possível transferir para si mesmo.';
}
