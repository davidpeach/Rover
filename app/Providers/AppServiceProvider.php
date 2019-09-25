<?php

namespace App\Providers;

use App\ControlCentre\ControlCentre;
use App\ControlCentre\OutputParser;
use App\ControlCentre\RouteParser;
use App\Models\Rover;
use App\Rover\MoveRoverForward;
use App\Rover\TurnRoverLeft;
use App\Rover\TurnRoverRight;
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

        $this->app->bind(Rover::class, function () {

            $validRoverMoves = [
                'F' => MoveRoverForward::class,
                'L' => TurnRoverLeft::class,
                'R' => TurnRoverRight::class,
            ];

            return new Rover($validRoverMoves);
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
