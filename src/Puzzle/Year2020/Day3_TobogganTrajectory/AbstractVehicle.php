<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

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
     */
    public function countEncounters(Map $map, int $x = 0, int $y = 0): int
    {
        // TODO: validate start position is not outside map boundaries
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