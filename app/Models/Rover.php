<?php

namespace App\Models;

use App\Exceptions\RoverOffGridException;
use App\Models\World;

class Rover
{
    private $world;

    private $lastKnownLocation = [];

    private $lost = false;

    private $validMoves;

    public function __construct(array $validMoves)
    {
        $this->validMoves = $validMoves;
    }

    /**
     * @param  World $world
     * @param  array $startingLocation
     * @return void
     */
    public function placeInWorld(World $world, array $startingLocation): void
    {
        $this->world = $world;

        $this->setLastKnownLocation($startingLocation);
    }

    /**
     * @param array $moves
     * @return void
     */
    public function setMoves(array $moves): void
    {
        $this->moves = $moves;
    }

    /**
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * @param array
     * @return void
     */
    public function setLastKnownLocation(array $location): void
    {
        $this->lastKnownLocation = array_merge($this->lastKnownLocation, $location);
    }

    /**
     * @return array
     */
    public function getLastKnownLocation(): array
    {
        return $this->lastKnownLocation;
    }

    /**
     * Execute all of the programmed moves
     * @return void
     */
    public function execute(): void
    {
        foreach ($this->moves as $move) {

            if ( ! array_key_exists($move, $this->validMoves)) {
                continue;
            }

            $movement = app($this->validMoves[$move]);

            $plannedMove = (new $movement)
                ->inWorld($this->world)
                ->from($this->getLastKnownLocation());

            try {
                $plannedMove->attempt();

                $this->setLastKnownLocation(
                    $plannedMove->getNextLocation()
                );
            } catch (RoverOffGridException $e) {
                throw $e;
            }
        }
    }

    /**
     * @return void
     */
    public function setAsLost(): void
    {
        $this->lost = true;
    }

    /**
     * @return boolean
     */
    public function isLost(): bool
    {
        return $this->lost;
    }

}
