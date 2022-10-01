<?php

namespace App\Domain\Auth\DTO;

use App\Application\Abstracts\DTOAbstract;

class AuthDTO extends DTOAbstract
{
    public $status;

    public $user;

    public array $authorization;
}
