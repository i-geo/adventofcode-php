<?php

namespace App\Puzzle\Year2020\Day2_PasswordPhilosophy;

use App\Puzzle\Exceptions\InvalidInput;

class PasswordPolicy implements Policy
{
    private const MIN = 1;
    private const MAX = 99;
    private int $min;
    private int $max;
    private string $character;

    /**
     * @param int $min
     * @param int $max
     * @param string $character
     * @throws InvalidInput
     */
    public function __construct(int $min, int $max, string $character)
    {
        $this->setMin($min);
        $this->setMax($max);
        $this->setCharacter($character);
    }

    /**
     * @param int $min
     * @throws InvalidInput
     */
    private function setMin(int $min): void
    {
        $this->validateNumber($min, 'min');
        $this->min = $min;
    }

    /**
     * @param int $max
     * @throws InvalidInput
     */
    private function setMax(int $max): void
    {
        $this->validateNumber($max, 'max');
        if ($this->min > $max) {
            throw new InvalidInput('max must be greater than min.');
        }
        $this->max = $max;
    }

    /**
     * @param string $character
     */
    private function setCharacter(string $character): void
    {
        $this->character = $character;
    }

    /**
     * Validates number is within the range
     * @param int $number
     * @param string $name
     * @return void
     * @throws InvalidInput
     */
    private function validateNumber(int $number, string $name = '')
    {
        if ($number < self::MIN || self::MAX < $number) {
            throw new InvalidInput(sprintf('%s must be between %d and %d.', $name, self::MIN, self::MAX));
        }
    }

    /**
     * Validates password is valid by checking how many times characters occurs within given boundaries: min, max
     * @inheritDoc
     */
    public function validPassword(string $password): bool
    {
        $count = substr_count($password, $this->character);
        return $this->min <= $count && $count <= $this->max;
    }
}