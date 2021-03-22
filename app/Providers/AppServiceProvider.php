<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use App\Route\ResourceRegistrar;
use Illuminate\Routing\Router;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        app()->bind(BaseResourceRegistrar::class, function () {
            return new ResourceRegistrar(app()->make(Router::class));
        });
    }
}
