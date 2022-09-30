<?php

namespace App\Domain\Auth\Provider;

use App\Application\Abstracts\ServiceProviderAbstract;
use App\Domain\Auth\Contracts\AuthRepositoryInterface;
use App\Domain\Auth\Repository\AuthRepository;

class AuthServiceProvider extends ServiceProviderAbstract
{
    public array $bindings = [
        AuthRepositoryInterface::class => AuthRepository::class
    ];
}
