<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;
// Vehicle
interface Encounterable
{
    /**
     * Count how many encounters the vehicle will do on the map, from start position
     * @param Map $map
     * @param int $x
     * @param int $y
     * @return int
     */
    public function countEncounters(Map $map, int $x = 0, int $y = 0): int;
}