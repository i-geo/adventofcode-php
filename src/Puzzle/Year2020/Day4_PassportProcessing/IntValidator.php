<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

class IntValidator extends Validator
{
    private int $min;
    private int $max;

    /**
     * @param int $min
     * @param int $max
     * @param string $validationPattern
     */
    public function __construct(int $min, int $max, string $validationPattern = '')
    {
        $validationPattern = empty($validationPattern) ? '/^(\d*)$/' : $validationPattern;
        parent::__construct($validationPattern);
        $this->min = $min;
        $this->max = $max;
    }

    public function validate(string $value): bool
    {
        parent::validate($value);

        $value = (int)$value;
        if ($this->min > $value || $value > $this->max) {
            throw new ValidationFailed("$value must be between {$this->min} and {$this->max}");
        }
        return true;
    }
}