<?php

namespace App\Exceptions\Domain;

use DomainException;

class AlreadyReversedException extends DomainException
{
    protected $message = 'Esta operação já foi revertida.';
}
