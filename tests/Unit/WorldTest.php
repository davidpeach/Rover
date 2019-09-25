<?php

namespace Tests\Unit;

use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorldTest extends TestCase
{
    /** @test */
    public function the_world_size_will_be_correctly_parsed_from_correct_input()
    {
    	$world = new World('4 8');

    	$this->assertEquals([
    		'x' => 4,
    		'y' => 8,
    	], $world->size());
    }

    /** @test */
    public function the_world_will_report_if_a_planned_move_is_valid()
    {
    	$world = new World('5 5');

    	$this->assertTrue($world->checkMoveIsValid([
    		'x' => 3,
    		'y' => 5,
    	]));
    }

    /** @test */
    public function the_world_will_report_if_a_planned_move_is_too_far_north()
    {
    	$world = new World('5 5');

    	$this->assertFalse($world->checkMoveIsValid([
    		'x' => 3,
    		'y' => 6,
    	]));
    }

    /** @test */
    public function the_world_will_report_if_a_planned_move_is_too_far_east()
    {
    	$world = new World('5 5');

    	$this->assertFalse($world->checkMoveIsValid([
    		'x' => 6,
    		'y' => 3,
    	]));
    }

    /** @test */
    public function the_world_will_report_if_a_planned_move_is_too_far_south()
    {
    	$world = new World('5 5');

    	$this->assertFalse($world->checkMoveIsValid([
    		'x' => 3,
    		'y' => -1,
    	]));
    }

    /** @test */
    public function the_world_will_report_if_a_planned_move_is_too_far_west()
    {
    	$world = new World('5 5');

    	$this->assertFalse($world->checkMoveIsValid([
    		'x' => -1,
    		'y' => 3,
    	]));
    }
}
