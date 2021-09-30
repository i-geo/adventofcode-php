<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day1_ReportRepair;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Exceptions\NoSolution;
use App\Puzzle\Year2020\Day1_ReportRepair\Part2;
use PHPUnit\Framework\TestCase;

class Part2Test extends TestCase
{
    private const PUZZLE_INPUT_MULTI_LINE = <<<'EOT'
        1721
        979
        366
        299
        675
        1456
        EOT;

    /**
     * 2020/Part2 Object.
     *
     * @var Part2
     */
    private Part2 $part2;

    public function inputOutputProvider(): array
    {
        return [
            // positive
            'only solution' => ["979\n366\n675", 241861950],
            'early exit sum' => ["\n200\n979\n366\n675\n1980\n2119", 241861950],
            'multi line' => [self::PUZZLE_INPUT_MULTI_LINE, 241861950]
        ];
    }

    public function invalidInputProvider(): array
    {
        return [
            // negative tests
            'empty' => ['', InvalidInput::class, 'Empty input, please provide some data.'],
            'whitespace' => [" \t\r", InvalidInput::class, 'Insufficient input, please provide more data.'],
            'single number' => ['123', InvalidInput::class, 'Insufficient input, please provide more data.'],
            'no solution small numbers' => ["1\n20", NoSolution::class, 'No solution found.'],
            'no solution larger number exit' => ["1\n2021\n3000", NoSolution::class, 'No solution found.'],
        ];
    }

    /**
     * @dataProvider inputOutputProvider
     */
    public function testSolution(string $input, int $output): void
    {
        $this->assertEquals($output, $this->part2->solution($input));
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testSolutionException(string $input, string $exceptionClass, string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $this->part2->solution($input);
    }

    protected function setUp(): void
    {
        $this->part2 = new Part2();
    }
}
