<?php

namespace App\Puzzle\Year2020\Day2_PasswordPhilosophy;

use App\Puzzle\Exceptions\InvalidInput;

class PasswordPolicy2 implements Policy
{
    private const MIN = 1;
    private const MAX = 99;
    private int $pos1;
    private int $pos2;
    private string $character;

    /**
     * @param int $pos1
     * @param int $pos2
     * @param string $character
     * @throws InvalidInput
     */
    public function __construct(int $pos1, int $pos2, string $character)
    {
        $this->setPos1($pos1);
        $this->setPos2($pos2);
        $this->setCharacter($character);
    }

    /**
     * @param int $pos1
     * @throws InvalidInput
     */
    private function setPos1(int $pos1): void
    {
        $this->validateNumber($pos1, 'pos1');
        $this->pos1 = $pos1;
    }

    /**
     * @param int $pos2
     * @throws InvalidInput
     */
    private function setPos2(int $pos2): void
    {
        $this->validateNumber($pos2, 'pos2');
        if ($this->pos1 > $pos2) {
            throw new InvalidInput('pos2 must be greater than pos1.');
        }
        $this->pos2 = $pos2;
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
     * Validates password is valid by checking how characters at pos1 & pos2
     * @inheritDoc
     */
    public function validPassword(string $password): bool
    {
        $passLength = strlen($password);
        if ($this->pos1 > $passLength || $this->pos2 > $passLength) {
            // Invalid password length
            return false;
        }
        $char1 = substr($password, $this->pos1 - 1, 1);
        $char2 = substr($password, $this->pos2 - 1, 1);
        if ($char1 === $this->character && $char2 === $this->character) {
            // both are matching - invalid
            return false;
        }
        if ($char1 === $this->character || $char2 === $this->character) {
            // either one are matching - valid
            return true;
        }
        // no matching - invalid
        return false;
    }
}