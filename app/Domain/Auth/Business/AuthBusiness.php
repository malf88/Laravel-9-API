<?php

namespace App\Domain\Auth\Business;

use App\Application\Exceptions\UnauthorizedException;
use App\Domain\Auth\Contracts\AuthBusinessInterface;
use App\Domain\Auth\Contracts\AuthRepositoryInterface;
use App\Domain\Auth\DTO\AuthDTO;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Helper\AuthHelper;

class AuthBusiness implements AuthBusinessInterface
{
    public function __construct(
        private AuthRepositoryInterface $authRepository
    ) {
    }

    public function login(UserDTO $user): AuthDTO
    {
        $token = AuthHelper::attempt($user->toArray());

        if (! $token) {
            throw new UnauthorizedException();
        }
        $user = new UserDTO(AuthHelper::user()->toArray());

        return new AuthDTO(
            status: 'success',
            user: $user,
            authorization: [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => AuthHelper::factory()->getTTL() * 60
            ]
        );
    }

    public function register(UserDTO $userDTO): AuthDTO
    {
        $user = $this->authRepository->insertUser($userDTO);

        $token = AuthHelper::attempt($userDTO->toArray());

        return new AuthDTO(
            status: 'success',
            user: $user,
            authorization: [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => AuthHelper::factory()->getTTL() * 60,
            ]
        );
    }

    public function refresh(): AuthDTO
    {
        $user = new UserDTO(AuthHelper::user()->toArray());
        $token = AuthHelper::refresh(true, true);

        return new AuthDTO(
            status: 'success',
            message: 'User created successfully',
            user: $user,
            authorization: [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => AuthHelper::factory()->getTTL() * 60,
            ]
        );
    }
}
