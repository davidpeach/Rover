<?php

namespace Tests\Unit;

use App\Models\Rover;
use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoverTest extends TestCase
{
    /** @test */
    public function a_rover_can_be_placed_in_a_world()
    {
    	$rover = app(Rover::class);
    	$world = new World('5 5');

    	$rover->placeInWorld($world, [
    		'x' => 1,
    		'y' => 3,
    		'orientation' => 'N'
    	]);

    	$this->assertEquals([
    		'x' => 1,
    		'y' => 3,
    		'orientation' => 'N'
    	], $rover->getLastKnownLocation());
    }

    /** @test */
    public function a_rover_can_have_its_moves_set()
    {
        $rover = app(Rover::class);

        $rover->setMoves(['F', 'R', 'R', 'F', 'L']);

        $this->assertEquals(['F', 'R', 'R', 'F', 'L'], $rover->getMoves());
    }
}
