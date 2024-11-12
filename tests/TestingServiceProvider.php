<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests;

use Illuminate\Support\ServiceProvider;

class TestingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(
            __DIR__.'/migrations'
        );
    }
}
