<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

class FieldType
{
    private string $name;
    private string $description;
    private Validatable $validator;

    /**
     * @param string $name
     * @param string $description
     * @param Validatable $validator
     */
    public function __construct(string $name, string $description, Validatable $validator)
    {
        $this->name = $name;
        $this->description = $description;
        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Validatable
     */
    public function getValidator(): Validatable
    {
        return $this->validator;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "$this->description ($this->name)";
    }
}