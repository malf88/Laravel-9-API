<?php

namespace App\Application\Abstracts;

use Illuminate\Support\ServiceProvider;

abstract class ServiceProviderAbstract extends ServiceProvider
{
    public array $bindings = [];
    public function provides()
    {
        return array_keys($this->bindings);
    }

}
