<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

interface Validatable
{
    /**
     * Validate value
     * @param string $value
     * @return bool
     * @throws ValidationFailed
     */
    public function validate(string $value): bool;

    /**
     * Returns mandatory
     * @return bool
     */
    public function isMandatory(): bool;
}