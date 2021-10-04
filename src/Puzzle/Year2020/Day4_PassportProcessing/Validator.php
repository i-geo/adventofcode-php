<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

abstract class Validator implements Validatable
{
    private string $validationPattern;
    private bool $mandatory;

    /**
     * @param string $validationPattern
     * @param bool $mandatory
     */
    public function __construct(string $validationPattern, bool $mandatory = true)
    {
        $this->validationPattern = $validationPattern;
        $this->mandatory = $mandatory;
    }

    /**
     * @return bool
     */
    public function isMandatory(): bool
    {
        return $this->mandatory;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $value): bool
    {
        $matched = preg_match($this->validationPattern, $value);
        if (!$matched) {
            throw new ValidationFailed("$value must match: $this->validationPattern");
        }

        return true;
    }
}