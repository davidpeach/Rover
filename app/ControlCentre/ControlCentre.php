<?php

namespace App\ControlCentre;

use App\ControlCentre\OutputParser;
use App\ControlCentre\RouteParser;
use App\Exceptions\RoverOffGridException;
use App\Models\Rover;
use App\Models\World;

class ControlCentre
{
	private $routeParser;
	private $outputParser;
	private $rovers = [];

	public function __construct(RouteParser $routeParser, OutputParser $outputParser)
	{
		$this->routeParser = $routeParser;
		$this->outputParser = $outputParser;
	}

	public function configureRoutes(string $routeData)
	{
		$routeConfigs = explode("\n", $routeData);

		$worldSize = array_shift($routeConfigs);
		$world = new World($worldSize);

		foreach ($routeConfigs as $config) {
			$this->routeParser->parse($config);
			$rover = new Rover;

			$rover->placeInWorld($world, $this->routeParser->getStartingLocation());
			$rover->setMoves($this->routeParser->getMoves());

			$this->rovers[] = $rover;
		}
	}

	public function executeRoutes()
	{
		foreach ($this->rovers as $rover) {
			try {
				$rover->execute();
			} catch (RoverOffGridException $e) {
				$rover->setAsLost();
			}
		}
	}

	public function locateRovers()
	{
		$locations = [];

		foreach ($this->rovers as $rover) {
			$locations[] = $this->outputParser->parse($rover->getLastKnownLocation(), $rover->isLost());
		}

		return implode("\n", $locations);
	}

}
