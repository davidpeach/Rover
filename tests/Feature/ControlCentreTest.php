<?php

namespace Tests\Feature;

use App\ControlCentre\ControlCentre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControlCentreTest extends TestCase
{
    /** @test */
    public function the_control_centre_can_send_rover_on_first_succesful_predetermined_route()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "4 8\n(2, 3, N) FLLFR";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(2, 3, W)", $controlCentre->locateRovers());
    }

    /** @test */
    public function the_control_centre_can_send_rover_on_second_succesful_predetermined_route()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "5 4\n(3, 0, W) FFRFFR";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(1, 2, E)", $controlCentre->locateRovers());
    }

    /** @test */
    public function the_control_centre_will_lose_the_first_rover_with_a_route_that_goes_off_grid()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "4 4\n(2, 1, N) FFFF";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(2, 3, N) LOST", $controlCentre->locateRovers());
    }

    /** @test */
    public function the_control_centre_will_lose_the_second_rover_with_a_route_that_goes_off_grid()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "4 8\n(1, 0, S) FFRLF";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(1, 0, S) LOST", $controlCentre->locateRovers());
    }

    /** @test */
    public function the_control_centre_will_lose_the_third_rover_with_a_route_that_goes_off_grid()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "3 3\n(2, 2, S) FFRFRFFFFFF";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(1, 2, N) LOST", $controlCentre->locateRovers());
    }

    /** @test */
    public function the_control_centre_can_send_multiple_rovers_on_routes_and_get_correct_report_back()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "4 8\n(2, 3, N) FLLFR\n(1, 0, S) FFRLF\n(3, 7, S) RFFLFFFRFLFFLFF";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(2, 3, W)\n(1, 0, S) LOST\n(2, 2, E)", $controlCentre->locateRovers());
    }

    /** @test */
    public function the_control_centre_will_ignore_invalid_directions_in_config()
    {
        $controlCentre = app(ControlCentre::class);
        $routeData = "4 8\n(2, 3, N) FLLIFR";
        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->assertEquals("(2, 3, W)", $controlCentre->locateRovers());
    }
}
