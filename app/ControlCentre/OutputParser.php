<?php

namespace App\ControlCentre;

class OutputParser
{
	public function parse(array $location, bool $isLost): string
	{
		$location = "({$location['x']}, {$location['y']}, {$location['orientation']})";

		if ($isLost === true) {
			$location .= " LOST";
		}

		return $location;
	}

}