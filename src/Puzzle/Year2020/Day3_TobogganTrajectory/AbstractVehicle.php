<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;

class AbstractVehicle implements Encounterable
{
    private int $down;
    private int $right;

    public function __construct(int $down, int $right)
    {
        $this->down = $down;
        $this->right = $right;
    }

    /**
     * @inheritDoc
     * @throws InvalidInput
     */
    public function countEncounters(Map $map, int $x = 0, int $y = 0): int
    {
        $mapWidth = $map->getWidth();
        if ($x > $mapWidth) {
            throw new InvalidInput('Start x position cannot be larger than map width.');
        }
        $mapHeight = $map->getHeight();
        if ($y > $mapHeight) {
            throw new InvalidInput('Start y position cannot be larger than map height.');
        }
        $count = 0;
        while ($y < $mapHeight) {
            if ($map->isEncounter($x, $y)) {
                $count++;
            }
            // move toboggan along the slope
            $x += $this->right;
            $y += $this->down;
        }

        return $count;
    }

}