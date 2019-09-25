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

    /**
     * @param RouteParser
     * @param OutputParser
     */
    public function __construct(RouteParser $routeParser, OutputParser $outputParser)
    {
        $this->routeParser = $routeParser;
        $this->outputParser = $outputParser;
    }

    /**
     * Setup new Rovers with directions and place them in the new World.
     * @param  string
     * @return void
     */
    public function configureRoutes(string $routeData): void
    {
        $routeConfigs = explode("\n", $routeData);

        $worldSize = array_shift($routeConfigs);
        $world = new World($worldSize);

        foreach ($routeConfigs as $config) {
            $this->routeParser->parse($config);
            $rover = app(Rover::class);

            $rover->placeInWorld($world, $this->routeParser->getStartingLocation());
            $rover->setMoves($this->routeParser->getMoves());

            $this->rovers[] = $rover;
        }
    }

    /**
     * Execute the routes of each of the Rovers.
     * @return void
     */
    public function executeRoutes(): void
    {
        foreach ($this->rovers as $rover) {
            try {
                $rover->execute();
            } catch (RoverOffGridException $e) {
                $rover->setAsLost();
            }
        }
    }

    /**
     * Locate all of the Rovers and return string location in (x, y, orientation)
     * format. potentially with "LOST" if gone off grid.
     * @return string
     */
    public function locateRovers(): string
    {
        $locations = [];

        foreach ($this->rovers as $rover) {
            $locations[] = $this->outputParser->parse($rover->getLastKnownLocation(), $rover->isLost());
        }

        return implode("\n", $locations);
    }

}
