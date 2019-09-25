<?php

namespace App\ControlCentre;

class OutputParser
{
    /**
     * Turn the location information into a valid output string.
     * @param  array $location
     * @param  bool  $isLost
     * @return string
     */
    public function parse(array $location, bool $isLost): string
    {
        $location = "({$location['x']}, {$location['y']}, {$location['orientation']})";

        if ($isLost === true) {
            $location .= " LOST";
        }

        return $location;
    }

}