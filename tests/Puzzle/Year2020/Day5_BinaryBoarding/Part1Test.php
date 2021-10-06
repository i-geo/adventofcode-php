<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day5_BinaryBoarding;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Year2020\Day5_BinaryBoarding\BoardingPass;
use App\Puzzle\Year2020\Day5_BinaryBoarding\Part1;
use PHPUnit\Framework\TestCase;

class Part1Test extends TestCase
{
    private const PUZZLE_INPUT_MULTI_LINE = <<<'EOT'
        FFFFFFFLLL
        FFFFFFFLLR
        FFFFFFFLRL
        FFFFFFFLRR
        FFFFFFFRLL
        FFFFFFFRLR
        FFFFFFFRRL
        FFFFFFFRRR
        FFFFFFBLLL
        FFFFFFBLLR
        FFFFFFBLRL

        FFFFFFBRLL
        FFFFFFBRLR
        FFFFFFBRRL
        FFFFFFBRRR
        EOT;

    /**
     * Part 1.
     *
     * @var Part1
     */
    private Part1 $part1;

    protected function setUp(): void
    {
        $this->part1 = new Part1();
    }

    public function inputOutputProvider(): array
    {
        return [
            // positive tests
            '1-1' => ["FFFFFFFLLR\nFFFFFFFLRL\nFFFFFFFLRR\nFFFFFFFRLL\nFFFFFFFRLR\nFFFFFFFRRL\nFFFFFFFRRR", 8, 1],
            '1-4' => ["FFFFFFFLLL\nFFFFFFFLLR\nFFFFFFFLRL\n\nFFFFFFFRLL\nFFFFFFFRLR\nFFFFFFFRRL\nFFFFFFFRRR", 8, 4],
            '1-8' => ["FFFFFFFLLL\nFFFFFFFLLR\nFFFFFFFLRL\nFFFFFFFLRR\nFFFFFFFRLL\nFFFFFFFRLR\nFFFFFFFRRL\n", 8, 8],
            'multi line 2-4 => 12' => [self::PUZZLE_INPUT_MULTI_LINE, 16, 12],
            // edge cases
            'no passengers' => ['', 8, 1],
        ];
    }

    /**
     * @dataProvider inputOutputProvider
     */
    public function testSolution(string $input, int $numSeats, int $output): void
    {
        $this->part1->setNumberOfSeats($numSeats);
        $this->assertEquals($output, $this->part1->solution($input));
    }

    public function invalidInputProvider(): array
    {
        return [
            // negative tests
            'smaller size' => ['FFFFFFFLL', 8, InvalidInput::class, 'Boarding Pass 1 is invalid: Invalid length boarding pass: FFFFFFFLL.'],
            'larger size' => ['FFFFFFFLLRL', 8, InvalidInput::class, 'Boarding Pass 1 is invalid: Invalid length boarding pass: FFFFFFFLLRL.'],
            'invalid pass' => ['FFXFFFFLLR', 8, InvalidInput::class, 'Boarding Pass 1 is invalid: Invalid format boarding pass: FFXFFFFLLR.'],
            'all seats taken' => ["FFFFFFFLLL\nFFFFFFFLLR\nFFFFFFFLRL\nFFFFFFFLRR\nFFFFFFFRLL\nFFFFFFFRLR\nFFFFFFFRRL\nFFFFFFFRRR", 8, InvalidInput::class, 'All seats are taken.'],
            'too many' => ["FFFFFFFLLL\nFFFFFFFLLR\nFFFFFFFLRL\nFFFFFFFLRR\nFFFFFFFRLL\nFFFFFFFRLR\nFFFFFFFRRL\nFFFFFFFRRR\nFFFFFFBLLL", 8, InvalidInput::class, 'Too many boarding passes for this plane, should be less than plane capacity: 8'],
            'smaller number of seats' => ['', 1, InvalidInput::class, 'Number of seats cannot be less than: ' . BoardingPass::MIN_NUM_PLANE_SEATS],
            'larger number of seats' => ['', 1025, InvalidInput::class, 'Number of seats cannot be more than: ' . BoardingPass::MAX_NUM_PLANE_SEATS],
        ];
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testSolutionException(string $input, int $numSeats, string $exceptionClass, string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $this->part1->setNumberOfSeats($numSeats);
        $this->part1->solution($input);
    }

}