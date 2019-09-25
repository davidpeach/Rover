<?php

namespace App\Rover;

use App\Models\World;

interface RoverMoveInterface
{
    /**
     * Work out the planned location to move to.
     * @return array
     */
    public function getPlannedLocation(): array;
}