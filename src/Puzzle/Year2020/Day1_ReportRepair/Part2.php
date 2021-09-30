<?php
/*
# --- Part Two ---

The Elves in accounting are thankful for your help; one of them even offers you a starfish coin they had left over from a past vacation. They offer you a second one if you can find three numbers in your expense report that meet the same criteria.

Using the above example again, the three entries that sum to `2020` are `979`, `366`, and `675`. Multiplying them together produces the answer, `241861950`.

In your expense report, what is the product of the three entries that sum to `2020`?

`Your puzzle answer was 68348924.`

Both parts of this puzzle are complete! They provide two gold stars: **


*/

namespace App\Puzzle\Year2020\Day1_ReportRepair;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Exceptions\NoSolution;
use App\Puzzle\PuzzleInterface;

class Part2 implements PuzzleInterface
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
        [$first, $second, $third] = $this->findTriple($expectedSum, $data);

        return $first * $second * $third;
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
    private function findTriple(int $expectedSum, array $data): array
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
                // or if intermediate sum is bigger no need to continue
                if ($second > $expectedSum || ($first + $second) > $expectedSum) {
                    break;
                }

                for ($k = $j + 1; $k <= $size; $k++) {
                    $third = (int)$data[$k];
                    $currentSum = ($first + $second + $third);
                    // exist loop early if number is larger than expected sum
                    // if total sum is bigger no need to continue
                    if ($third > $expectedSum || $currentSum > $expectedSum) {
                        break;
                    }

                    // when equal just return the result
                    if ($currentSum === $expectedSum) {
                        return [$first, $second, $third];
                    }
                }
            }
        }

        throw new NoSolution('No solution found.');
    }


}
