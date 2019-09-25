<?php

namespace App\ControlCentre;

class RouteParser
{
	private $moves;

	private $startingLocation;

	public function parse(string $input)
	{
		$moves = preg_replace_callback("/.*\(([^)]*)\)/", function ($matches) {
			$this->parseStartingLocation($matches[1]);
		}, $input);

		$this->parseMoves($moves);
	}

	public function parseStartingLocation(string $startingLocation)
	{
		$locationArray = explode(',', str_replace(' ', '', $startingLocation));
		$this->startingLocation['x'] = (int) $locationArray[0];
		$this->startingLocation['y'] = (int) $locationArray[1];
		$this->startingLocation['orientation'] = $locationArray[2];
	}

	public function parseMoves(string $moves)
	{
		$this->moves = trim($moves);
	}

	public function getStartingLocation()
	{
		return $this->startingLocation;
	}

	public function getMoves()
	{
		return str_split($this->moves);
	}


}