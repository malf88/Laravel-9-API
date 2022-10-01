<?php

namespace App\Domain\Auth\Repository;

use App\Domain\Auth\Contracts\AuthRepositoryInterface;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function insertUser(UserDTO $userDTO): UserDTO
    {
        $user = new User($userDTO->toArray());
        $user->password = Hash::make($user->password);
        $user->save();

        return new UserDTO($user->toArray());
    }
}
