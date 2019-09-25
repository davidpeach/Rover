<?php

namespace App\Models;

class World
{
    private $size;

    /**
     * @param string $size
     */
    public function __construct(string $size)
    {
        list($m, $n) = explode(' ', $size);
        $this->size['m'] = (int) $m;
        $this->size['n'] = (int) $n;
    }

    /**
     * Return the size of the world in an ['x' => 5, 'y' => 5] format.
     * @return array
     */
    public function size(): array
    {
        return $this->size;
    }

    /**
     * Check whether the planned move sends the robot off the world grid.
     * @param  array $plannedMove
     * @return boolean
     */
    public function checkMoveIsValid(array $plannedMove): bool
    {
        if ($plannedMove['x'] >= $this->size['m']) {
            return false;
        }

        if ($plannedMove['x'] < 0) {
            return false;
        }

        if ($plannedMove['y'] >= $this->size['n']) {
            return false;
        }

        if ($plannedMove['y'] < 0) {
            return false;
        }

        return true;
    }


}
