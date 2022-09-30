<?php

namespace App\Domain\Auth\Repository;

use App\Domain\Auth\Contracts\AuthRepositoryInterface;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Models\User;

class AuthRepository implements AuthRepositoryInterface
{

    public function insertUser(UserDTO $userDTO) : UserDTO
    {
        $user = User::create($userDTO->toArray());
        return new UserDTO($user->toArray());

    }
}
