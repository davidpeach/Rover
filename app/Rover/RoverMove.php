<?php

namespace App\Rover;

use App\Exceptions\RoverOffGridException;
use App\Models\World;

class RoverMove
{
    const NORTH = 'N';
    const EAST = 'E';
    const SOUTH = 'S';
    const WEST = 'W';

    protected $currentLocation;

    private $nextLocation;

    protected $directions = [
        SELF::NORTH,
        SELF::EAST,
        SELF::SOUTH,
        SELF::WEST,
    ];

    /**
     * Set the world in which to move.
     * @param  World $world
     * @return self
     */
    public function inWorld(World $world): self
    {
        $this->world = $world;

        return $this;
    }

    /**
     * The Rover's current location to move from.
     * @param  array
     * @return self
     */
    public function from(array $currentLocation): self
    {
        $this->currentLocation = $currentLocation;

        return $this;
    }

    /**
     * Attempt to make the next planned move
     * @return self
     */
    public function attempt(): self
    {
        $this->nextLocation = array_merge($this->currentLocation, $this->getPlannedLocation());

        if ( ! $this->world->checkMoveIsValid($this->nextLocation)) {
            throw new RoverOffGridException;
        }

        return $this;
    }

    /**
     * Get the next location to move to.
     * @return array
     */
    public function getNextLocation(): array
    {
        return $this->nextLocation;
    }

}