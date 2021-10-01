<?php

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;

class TreeMap implements Map
{
    private const WHITE_SPACE_CHARACTERS = ["\r", "\t", ' '];
    private const NEW_LINE = "\n";

    private string $openCharacter;
    private string $treeCharacter;
    private array $data;
    private int $width;
    private int $height;

    /**
     * @throws InvalidInput
     */
    public function __construct(mixed $input, string $openCharacter, string $treeCharacter)
    {
        // TODO: needs validation
        $this->openCharacter = $openCharacter;
        $this->treeCharacter = $treeCharacter;

        $this->data = $this->prepareData($input);
        $this->height = count($this->data);
        $this->width = strlen($this->data[0]);
    }

    /**
     * Validate and prepare data from input
     * @param mixed $input
     * @return array
     * @throws InvalidInput
     */
    private function prepareData(mixed $input): array
    {
        // remove all whitespace characters
        $cleanData = str_replace(self::WHITE_SPACE_CHARACTERS, '', $input);

        // validate if empty
        if (empty($cleanData)) {
            throw new InvalidInput('Empty input, please provide some data.');
        }

        // into array
        $data = explode(self::NEW_LINE, $cleanData);
        foreach ($data as $line) {
            $this->validateLine($line);
        }
        return $data;
    }

    /**
     * @param string $line
     * @return void
     * @throws InvalidInput
     */
    private function validateLine(string $line)
    {
        $pattern = '/[^' . $this->openCharacter . $this->treeCharacter . '.$]/';
        if (preg_match($pattern, $line)) {
            throw new  InvalidInput("Incorrect input on line 1, must be open squares ($this->openCharacter) or trees ($this->treeCharacter).");
        }
    }

    /**
     * @inheritDoc
     */
    public function isEncounter(int $x, int $y): bool
    {
        $line = $this->data[$y];
        $x = $x % $this->width;
        $object = $line[$x];
        return $object === $this->treeCharacter;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}