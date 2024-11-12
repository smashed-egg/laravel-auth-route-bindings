<?php

namespace SmashedEgg\LaravelAuthRouteBindings;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteBindingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerRouteBindings();
    }

    protected function registerRouteBindings(): void
    {
        Route::macro('modelAuth', function (
            string $binding,
            string $className,
            ?string $userForeignKey = 'user_id',
            ?string $field = 'id'
        ) {
            Route::bind($binding, function ($value, \Illuminate\Routing\Route $route) use (
                $binding,
                $className,
                $userForeignKey,
                $field
            ) {
                $field = $route->bindingFieldFor($binding) ?: $field;

                $modelClass = app()->make($className);

                return $modelClass::query()
                    ->where($field, $value)
                    ->where($userForeignKey, auth()->user()->getAuthIdentifier())
                    ->firstOrFail()
                ;
            });
        });
    }
}
