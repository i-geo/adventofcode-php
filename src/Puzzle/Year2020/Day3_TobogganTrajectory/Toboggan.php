<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;

class Toboggan extends AbstractVehicle implements Encounterable
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
        $this->validateMapStartPos($map, $x, $y);
        $mapHeight = $map->getHeight();
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