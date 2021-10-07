<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;

abstract class AbstractVehicle implements Encounterable
{
    /**
     * Validates startup coordinates on the map
     * @param Map $map
     * @param int $x
     * @param int $y
     * @return void
     * @throws InvalidInput
     */
    protected function validateMapStartPos(Map $map, int $x = 0, int $y = 0): void
    {
        $mapWidth = $map->getWidth();
        if ($x > $mapWidth) {
            throw new InvalidInput('Start x position cannot be larger than map width.');
        }
        $mapHeight = $map->getHeight();
        if ($y > $mapHeight) {
            throw new InvalidInput('Start y position cannot be larger than map height.');
        }
    }

    /**
     * @inheritDoc
     * @throws InvalidInput
     */
    abstract public function countEncounters(Map $map, int $x = 0, int $y = 0): int;

}