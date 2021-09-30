<?php

namespace App\Puzzle;

interface PuzzleInterface
{
    /**
     * Puzzle entry method.
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function solution(mixed $input): mixed;
}
