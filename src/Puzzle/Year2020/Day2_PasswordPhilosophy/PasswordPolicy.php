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
        $this->setMin($min)
            ->setMax($max)
            ->setCharacter($character);
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @param int $min
     * @return PasswordPolicy
     * @throws InvalidInput
     */
    public function setMin(int $min): PasswordPolicy
    {
        $this->validateNumber($min, 'min');
        $this->min = $min;
        return $this;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @return PasswordPolicy
     * @throws InvalidInput
     */
    public function setMax(int $max): PasswordPolicy
    {
        $this->validateNumber($max, 'max');
        if ($this->min > $max) {
            throw new InvalidInput('max must be greater than min.');
        }
        $this->max = $max;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharacter(): string
    {
        return $this->character;
    }

    /**
     * @param string $character
     * @return PasswordPolicy
     */
    public function setCharacter(string $character): PasswordPolicy
    {
        $this->character = $character;
        return $this;
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