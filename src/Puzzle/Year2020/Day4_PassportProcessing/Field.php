<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

class Field
{

    private FieldType $fieldType;
    private mixed $value;

    public function __construct(FieldType $fieldType, mixed $value)
    {
        $this->fieldType = $fieldType;
        $this->value = $value;
    }

    /**
     * @return FieldType
     */
    public function getFieldType(): FieldType
    {
        return $this->fieldType;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "$this->fieldType: $this->value";
    }
}