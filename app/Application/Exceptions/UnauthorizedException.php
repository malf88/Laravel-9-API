<?php

namespace App\Application\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Acesso não autorizado', '401');
    }
}
