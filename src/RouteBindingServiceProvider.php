<?php

namespace SmashedEgg\LaravelAuthRouteBindings;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\ServiceProvider;

class RouteBindingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Resources/config/route_bindings.php' => config_path('smashed_egg/route_bindings.php'),
        ]);

        $this->registerRouteBindings();
    }

    protected function registerRouteBindings()
    {
        collect(config('route_binding.models', []))->each(function($config, $binding) {

            RouteFacade::bind($binding, function ($value, \Illuminate\Routing\Route $route) use ($binding, $config) {

                $field = $route->bindingFieldFor($binding) ?: $config['field'];

                $modelClass = $config['class'];

                return $modelClass::query()
                    ->where($field, $value)
                    ->where($config['fk_user_id'], auth()->user()->getAuthIdentifier())
                    ->firstOrFail()
                ;
            });

        });
    }

}
