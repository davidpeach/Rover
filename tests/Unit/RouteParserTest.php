<?php

namespace Tests\Unit;

use App\ControlCentre\RouteParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteParserTest extends TestCase
{
    /** @test */
    public function a_route_can_be_configured_based_on_correct_config()
    {
    	$routeParser = new RouteParser;
        $routeParser->parse("(2, 3, N) FLLFR");

    	$this->assertEquals([
    		'x' => 2,
    		'y' => 3,
    		'orientation' => 'N',
    	], $routeParser->getStartingLocation());
    }

    /** @test */
    public function a_set_of_moves_can_can_configured_based_on_correct_config()
    {
    	$routeParser = new RouteParser;
        $routeParser->parse("(2, 3, N) FLLFR");

    	$this->assertEquals([
            'F', 'L', 'L', 'F', 'R',
        ], $routeParser->getMoves());
    }
}
