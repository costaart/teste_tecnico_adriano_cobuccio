<?php

namespace App\Exceptions\Domain;

use DomainException;

class UnauthorizedReversalException extends DomainException
{
    protected $message = 'Você não tem permissão para reverter esta operação.';
}
