<?php

namespace App\Providers;

use App\ControlCentre\ControlCentre;
use App\ControlCentre\OutputParser;
use App\ControlCentre\RouteParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ControlCentre::class, function () {
            return new ControlCentre(
                app(RouteParser::class),
                app(OutputParser::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
