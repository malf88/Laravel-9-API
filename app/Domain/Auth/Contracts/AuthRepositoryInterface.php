<?php

namespace App\Domain\Auth\Contracts;

use App\Domain\Auth\DTO\UserDTO;

interface AuthRepositoryInterface
{
    public function insertUser(UserDTO $userDTO): UserDTO;
}
