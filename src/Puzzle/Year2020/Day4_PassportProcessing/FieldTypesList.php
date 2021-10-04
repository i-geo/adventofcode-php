<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

use Iterator;

/**
 * @implements Iterator<string,FieldType>
 */
class FieldTypesList implements Iterator
{
    /**
     * @var array<FieldType>
     */
    protected array $fields = [];

    /**
     * @inheritDoc
     */
    public function current(): FieldType
    {
        return current($this->fields);
    }

    /**
     * @inheritDoc
     */
    public function next(): FieldType|false
    {
        return next($this->fields);
    }

    /**
     * @inheritDoc
     */
    public function key(): ?string
    {
        return key($this->fields);
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
        reset($this->fields);
    }

    /**
     * Adds FieldType to the list
     * @param FieldType $fieldType
     * @return void
     */
    public function add(FieldType $fieldType): void
    {
        $this->fields[$fieldType->getName()] = $fieldType;
    }

}