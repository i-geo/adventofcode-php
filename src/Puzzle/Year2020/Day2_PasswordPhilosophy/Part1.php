<?php

/*
# --- Day 1: Report Repair ---

After saving Christmas five years in a row, you've decided to take a vacation at a nice resort on a tropical island. Surely, Christmas will go on without you.

The tropical island has its own currency and is entirely cash-only. The gold coins used there have a little picture of a starfish; the locals just call them stars. None of the currency exchanges seem to have heard of them, but somehow, you'll need to find fifty of these coins by the time you arrive so you can pay the deposit on your room.

To save your vacation, you need to get all fifty stars by December 25th.

Collect stars by solving puzzles. Two puzzles will be made available on each day in the Advent calendar; the second puzzle is unlocked when you complete the first. Each puzzle grants one star. Good luck!

Before you leave, the Elves in accounting just need you to fix your expense report (your puzzle input); apparently, something isn't quite adding up.

Specifically, they need you to find the two entries that sum to 2020 and then multiply those two numbers together.

For example, suppose your expense report contained the following:
```
1721
979
366
299
675
1456
```
In this list, the two entries that sum to `2020` are `1721` and `299`. Multiplying them together produces `1721 * 299 = 514579`, so the correct answer is `514579`.

Of course, your expense report is much larger. Find the two entries that sum to 2020; what do you get if you multiply them together?

`Your puzzle answer was 633216.`


*/

namespace App\Puzzle\Year2020\Day2_PasswordPhilosophy;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Exceptions\NoSolution;
use App\Puzzle\PuzzleInterface;

class Part1 implements PuzzleInterface
{
    const WHITE_SPACE_CHARACTERS = ["\r", "\t"];
    const NEW_LINE = "\n";
    const LINE_FORMAT_REGEX = '/^(\d{1,2})-(\d{1,2}) ([\w]): ([\w].*)$/miu';

    /**
     * Finds how many passwords are valid according to their policies
     *
     * @param mixed $input Digits list
     *
     * @return int Sum
     * @throws InvalidInput
     */
    public function solution(mixed $input): int
    {
        $data = $this->prepareData($input);
        return $this->countValidPasswords($data);
    }

    /**
     * Validate and prepare data from input into expected format
     * @param mixed $input
     * @return array
     * @throws InvalidInput
     */
    private function prepareData(mixed $input): array
    {
        // validate if empty
        if (empty($input)) {
            throw new InvalidInput('Empty input, please provide some data.');
        }

        // remove all whitespace characters
        $cleanData = str_replace(self::WHITE_SPACE_CHARACTERS, '', $input);

        // into array
        $data = explode(self::NEW_LINE, $cleanData);
        if (empty($data)) {
            throw new InvalidInput('Insufficient input, please provide more data.');
        }

        $prepared = [];
        foreach ($data as $i => $datum) {
            $prepared[] = $this->validateExtract($datum, $i + 1);
        }

        return $prepared;
    }

    /**
     * Find if each password matches policies
     * Expects prepared array
     * @param array $data
     * @return int
     * @throws InvalidInput
     */
    private function countValidPasswords(array &$data): int
    {
        $count = 0;
        foreach ($data as $row) {
            $policy = new PasswordPolicy($row['min'], $row['max'], $row['character']);
            $count += $this->policyMatch($policy, $row['password']);
        }
        return $count;
    }

    /**
     * Validates line data is according to rules.
     * Validation can be added to extraction to speed up
     * @param string $text
     * @return array
     * @throws InvalidInput
     */
    private function validateExtract(string $text, int $lineNum): array
    {
        // Business Decision: Reject or ignore invalid lines?
        // For this exercise will reject on invalid
        if (preg_match(self::LINE_FORMAT_REGEX, $text, $match) !== 1) {
            throw new InvalidInput("Incorrect input on line $lineNum, please provide each line in format '<min>-<max> <character>:<password>'.");
        }

        return [
            'min' => $match[1],
            'max' => $match[2],
            'character' => $match[3],
            'password' => $match[4],
        ];
    }

    /**
     * Checks if password matches policy
     * @param Policy $policy
     * @param string $password
     * @return int
     */
    private function policyMatch(Policy $policy, string $password): int
    {
        return ($policy->validPassword($password)) ? 1 : 0;
    }

}
