<?php

namespace App\Domain\Auth\Provider;

use App\Application\Abstracts\ServiceProviderAbstract;
use App\Domain\Auth\Business\AuthBusiness;
use App\Domain\Auth\Contracts\AuthBusinessInterface;
use App\Domain\Auth\Contracts\AuthRepositoryInterface;
use App\Domain\Auth\Repository\AuthRepository;

class AuthServiceProvider extends ServiceProviderAbstract
{
    public array $bindings = [
        AuthRepositoryInterface::class => AuthRepository::class,
        AuthBusinessInterface::class => AuthBusiness::class,
    ];
}
