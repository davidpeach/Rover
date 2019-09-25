<?php

namespace App\Models;

use App\Exceptions\RoverOffGridException;
use App\Models\World;

class Rover
{
	private $world;

	private $startingLocation;

	private $lastKnownLocation = [];

	private $moves;

	private $inRange = true;

	private $directions = [
		'N',
		'E',
		'S',
		'W'
	];

	public function placeInWorld(World $world, array $startingLocation)
	{
		$this->world = $world;

		$this->setLastKnownLocation($startingLocation);
	}

	public function setMoves(array $moves)
	{
		$this->moves = $moves;
	}

	public function getMoves(): array
	{
		return $this->moves;
	}

	public function setLastKnownLocation($location)
	{
		$this->lastKnownLocation = array_merge($this->lastKnownLocation, $location);
	}

	public function getLastKnownLocation()
	{
		return $this->lastKnownLocation;
	}

	public function execute()
	{
		foreach ($this->moves as $nextMove) {
			if ($nextMove === 'F') {
				$this->moveForward();
			} else {
				$this->updateOrientation($nextMove);
			}
		}
	}

	public function moveForward()
	{
		$facing = $this->getLastKnownLocation()['orientation'];

		switch ($facing) {
			case 'N':
				$plannedMove = [
					'x' => $this->getLastKnownLocation()['x'],
					'y' => ++$this->getLastKnownLocation()['y'],
				];
				break;
			case 'E':
				$plannedMove = [
					'x' => ++$this->getLastKnownLocation()['x'],
					'y' => $this->getLastKnownLocation()['y'],
				];
				break;
			case 'S':
				$plannedMove = [
					'x' => $this->getLastKnownLocation()['x'],
					'y' => --$this->getLastKnownLocation()['y'],
				];
				break;
			case 'W':
				$plannedMove = [
					'x' => --$this->getLastKnownLocation()['x'],
					'y' => $this->getLastKnownLocation()['y'],
				];
				break;
			default:
				break;
		}

		if ($this->world->checkMoveIsValid($plannedMove)) {
			$this->setLastKnownLocation($plannedMove);
			return;
		}

		throw new RoverOffGridException;
	}

	public function updateOrientation(string $turnDirection)
	{
		if ($turnDirection === 'L') {
			$currentKey = array_search($this->getLastKnownLocation()['orientation'], $this->directions);
			--$currentKey;
			if ($currentKey < 0) {
				$currentKey = count($this->directions) - 1;
			}
		} else {
			$currentKey = array_search($this->getLastKnownLocation()['orientation'], $this->directions);
			++$currentKey;
			if ($currentKey > count($this->directions) - 1) {
				$currentKey = 0;
			}
		}
		$this->setLastKnownLocation(['orientation' => $this->directions[$currentKey]]);
	}

	public function setAsLost(): void
	{
		$this->inRange = false;
	}

	public function isLost(): bool
	{
		return ! $this->inRange;
	}

}
