<?php

namespace Tests\Unit;

use App\ControlCentre\OutputParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OutputParserTest extends TestCase
{
    /** @test */
    public function the_output_parser_will_turn_given_data_into_a_valid_location_string_for_a_locatable_rover()
    {
    	$outputParser = new OutputParser;

    	$this->assertEquals(
    		"(7, 3, W)",
    		$outputParser->parse([
	    		'x' => 7,
	    		'y' => 3,
	    		'orientation' => 'W',
	    	], $isLost = false)
	    );
    }

    /** @test */
    public function the_output_parser_will_turn_given_data_into_a_valid_location_string_for_a_lost_rover()
    {
    	$outputParser = new OutputParser;

    	$this->assertEquals(
    		"(4, 2, S) LOST",
    		$outputParser->parse([
	    		'x' => 4,
	    		'y' => 2,
	    		'orientation' => 'S',
	    	], $isLost = true)
	    );
    }
}
