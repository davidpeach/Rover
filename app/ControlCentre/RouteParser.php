<?php

namespace App\ControlCentre;

class RouteParser
{
    private $moves;

    private $startingLocation;

    /**
     * Parse given input string input workable arrays
     * @param  string $input
     * @return void
     */
    public function parse(string $input): void
    {
        $moves = preg_replace_callback("/.*\(([^)]*)\)/", function ($matches) {
            $this->parseStartingLocation($matches[1]);
        }, $input);

        $this->parseMoves($moves);
    }

    /**
     * Parse the starting location into an array
     * of [x, y, orientation]
     * @param  string $startingLocation
     * @return void
     */
    public function parseStartingLocation(string $startingLocation): void
    {
        $locationArray = explode(',', str_replace(' ', '', $startingLocation));
        $this->startingLocation['x'] = (int) $locationArray[0];
        $this->startingLocation['y'] = (int) $locationArray[1];
        $this->startingLocation['orientation'] = $locationArray[2];
    }

    /**
     * @param  string $moves
     * @return void
     */
    public function parseMoves(string $moves): void
    {
        $this->moves = trim($moves);
    }

    /**
     * @return array
     */
    public function getStartingLocation(): array
    {
        return $this->startingLocation;
    }

    /**
     * @return array
     */
    public function getMoves(): array
    {
        return str_split($this->moves);
    }


}