<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

class Passport
{
    private FieldsList $passportFields;

    /**
     * @param array<FieldsList> $passportData
     * @throws InvalidPassport
     */
    public function __construct(array $passportData, PassportValidator $passportValidator)
    {
        $this->passportFields = $passportValidator->extractFields($passportData);
    }

    /**
     * @return FieldsList
     */
    public function getPassportFields(): FieldsList
    {
        return $this->passportFields;
    }

    public function __toString(): string
    {
        $fieldStr = [];
        foreach ($this->getPassportFields() as $passportField) {
            $fieldStr[] = (string)$passportField;
        }

        return implode('; ', $fieldStr);
    }
}