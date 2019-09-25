<?php

namespace App\Rover;

use App\Models\World;
use App\Rover\RoverMovesInterface;

class TurnRoverRight extends RoverMove implements RoverMoveInterface
{
    /**
     * Work out the planned location to move to.
     * @return array
     */
    public function getPlannedLocation(): array
    {
        $currentKey = array_search($this->currentLocation['orientation'], $this->directions);

        ++$currentKey;

        if ($currentKey > count($this->directions) - 1) {
            $currentKey = 0;
        }

        return [
            'orientation' => $this->directions[$currentKey],
        ];
    }
}
