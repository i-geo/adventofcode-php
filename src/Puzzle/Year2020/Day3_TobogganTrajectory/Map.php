<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

interface Map
{
    /**
     * Checks if position is encounter
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isEncounter(int $x, int $y): bool;

    /**
     * Get map width
     * @return int
     */
    public function getWidth(): int;

    /**
     * Get map height
     * @return int
     */
    public function getHeight(): int;

}