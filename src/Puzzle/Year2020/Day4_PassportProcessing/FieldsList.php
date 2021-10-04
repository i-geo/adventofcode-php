<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

use Iterator;

/**
 * @implements Iterator<string,Field>
 */
class FieldsList implements Iterator
{
    /**
     * @var array<Field>
     */
    protected array $fields = [];

    /**
     * @inheritDoc
     */
    public function current(): Field
    {
        return current($this->fields);
    }

    /**
     * @inheritDoc
     */
    public function next(): Field|bool
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
     * Adds Field to the list
     * @param Field $field
     * @return void
     */
    public function add(Field $field): void
    {
        $this->fields[$field->getFieldType()->getName()] = $field;
    }


}