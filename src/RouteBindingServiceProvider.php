<?php

namespace SmashedEgg\LaravelAuthRouteBindings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteBindingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::macro('modelAuth', [$this, 'modelAuthHandler']);
    }

    /**
     * @param class-string<Model> $className
     */
    public static function modelAuthHandler(
        string $binding,
        string $className,
        ?string $userForeignKey = 'user_id',
        ?string $field = 'id'
    ): void {
        Route::bind($binding, function ($value, \Illuminate\Routing\Route $route) use (
            $binding,
            $className,
            $userForeignKey,
            $field
        ) {
            if ( ! auth()->user()) {
                throw (new ModelNotFoundException())->setModel($className);
            }

            $field = $route->bindingFieldFor($binding) ?: $field;

            $modelClass = app()->make($className);

            return $modelClass::query()
                ->where($field, $value)
                ->where($userForeignKey, auth()->user()->getAuthIdentifier())
                ->firstOrFail()
            ;
        });
    }
}
