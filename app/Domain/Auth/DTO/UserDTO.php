<?php

namespace App\Domain\Auth\DTO;

use App\Application\Abstracts\DTOAbstract;

class UserDTO extends DTOAbstract
{
    public string|null $name;

    public string|null $email;

    public string|null $password;
}
