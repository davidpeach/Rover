<?php

namespace App\Models;

class World
{
	private $size;

	public function __construct(string $size)
	{
		list($x, $y) = explode(' ', $size);
		$this->size['x'] = (int) $x;
		$this->size['y'] = (int) $y;
	}

	public function size()
	{
		return $this->size;
	}

	public function checkMoveIsValid(array $plannedMove)
	{
		if ($plannedMove['x'] > $this->size['x']) {
			return false;
		}

		if ($plannedMove['x'] < 0) {
			return false;
		}

		if ($plannedMove['y'] > $this->size['y']) {
			return false;
		}

		if ($plannedMove['y'] < 0) {
			return false;
		}

		return true;
	}


}
