<?php

namespace App\Domain\Auth\Contracts;

use App\Domain\Auth\DTO\AuthDTO;
use App\Domain\Auth\DTO\UserDTO;

interface AuthBusinessInterface
{
    public function login(UserDTO $request): AuthDTO;

    public function register(UserDTO $userDTO): AuthDTO;

    public function refresh(): AuthDTO;
}
