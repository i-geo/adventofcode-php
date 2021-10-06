<?php

namespace App\Puzzle\Year2020\Day5_BinaryBoarding;

use Iterator;

/**
 * @implements Iterator<int,BoardingPass>
 */
class BoardingPassesList implements Iterator
{
    /**
     * @var array<BoardingPass>
     */
    protected array $boardingPasses = [];

    /**
     * @inheritDoc
     */
    public function current(): BoardingPass
    {
        return current($this->boardingPasses);
    }

    /**
     * @inheritDoc
     */
    public function next(): BoardingPass|false
    {
        return next($this->boardingPasses);
    }

    /**
     * @inheritDoc
     */
    public function key(): ?int
    {
        return key($this->boardingPasses);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->key() !== null;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        reset($this->boardingPasses);
    }

    /**
     * Adds BoardingPass to the list
     * @param BoardingPass $boardingPass
     * @return void
     */
    public function add(BoardingPass $boardingPass): void
    {
        $seatNo = $boardingPass->seatNumber();
        $this->boardingPasses[$seatNo] = $boardingPass;
    }

}