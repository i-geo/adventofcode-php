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

namespace App\Puzzle\Year2020\Day1_ReportRepair;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Exceptions\NoSolution;
use App\Puzzle\PuzzleInterface;

class Part1 implements PuzzleInterface
{
    private const EXPECTED_SUM = 2020;
    const WHITE_SPACE_CHARACTERS = ["\r", "\t", ' '];
    const NEW_LINE = "\n";

    /**
     * Finds the sum of all digits that match the next digit in the circular list.
     *
     * @param mixed $input Digits list
     *
     * @return int Sum
     * @throws InvalidInput|NoSolution
     */
    public function solution(mixed $input): int
    {
        $expectedSum = self::EXPECTED_SUM;

        $data = $this->prepareData($input);
        [$first, $second] = $this->findPair($expectedSum, $data);

        return $first * $second;
    }

    /**
     * Validate and prepare data from input
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
        if (empty($data) || count($data) <= 1) {
            throw new InvalidInput('Insufficient input, please provide more data.');
        }

        sort($data);
        return $data;
    }

    /**
     * Find pair elements which sum matches $expectedSum.
     * Expects sorted array
     * Uses simple array walk method
     * Possible optimization if using Binary tree search, finds median point first and move toward the edges
     * @param int $expectedSum
     * @param array $data
     * @return array
     * @throws NoSolution
     */
    private function findPair(int $expectedSum, array $data): array
    {
        $size = count($data) - 1;
        foreach ($data as $i => $first) {
            $first = (int)$first;
            // exist early if number is larger than expected sum, subsequent numbers are larger
            if ($first > $expectedSum) {
                throw new NoSolution('No solution found.');
            }
            for ($j = $i + 1; $j <= $size; $j++) {
                $second = (int)$data[$j];
                // exist loop early if number is larger than expected sum
                if ($second > $expectedSum) {
                    break;
                }
                $currentSum = ($first + $second);
                // if sum is bigger no need to continue
                if ($currentSum > $expectedSum) {
                    break;
                }
                if ($currentSum === $expectedSum) {
                    return [$first, $second];
                }
            }
        }

        throw new NoSolution('No solution found.');
    }


}
