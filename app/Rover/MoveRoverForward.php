<?php

namespace App\Rover;

use App\Models\World;
use App\Rover\RoverMovesInterface;

class MoveRoverForward extends RoverMove implements RoverMoveInterface
{
    /**
     * Work out the planned location to move to.
     * @return array
     */
    public function getPlannedLocation(): array
    {
        switch ($this->currentLocation['orientation']) {
            case SELF::NORTH:
                return [
                    'x' => $this->currentLocation['x'],
                    'y' => ++$this->currentLocation['y'],
                ];
                break;
            case SELF::EAST:
                return [
                    'x' => ++$this->currentLocation['x'],
                    'y' => $this->currentLocation['y'],
                ];
                break;
            case SELF::SOUTH:
                return [
                    'x' => $this->currentLocation['x'],
                    'y' => --$this->currentLocation['y'],
                ];
                break;
            case SELF::WEST:
                return [
                    'x' => --$this->currentLocation['x'],
                    'y' => $this->currentLocation['y'],
                ];
                break;
            default:
                return [
                    'x' => $this->currentLocation['x'],
                    'y' => $this->currentLocation['y'],
                ];
                break;
        }
    }
}
