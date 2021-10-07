<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day2_PasswordPhilosophy;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Year2020\Day2_PasswordPhilosophy\Part2;
use PHPUnit\Framework\TestCase;

class Part2Test extends TestCase
{
    private const PUZZLE_INPUT_MULTI_LINE = <<<'EOT'
        1-3 a: abcde
        1-3 b: cdefg
        2-9 c: ccccccccc
        EOT;

    /**
     * Part 1.
     *
     * @var Part2
     */
    private Part2 $part2;

    public function inputOutputProvider(): array
    {
        return [
            // positive
            'valid 1' => ["1-3 a: abcde", 1],
            'invalid 1' => ["1-3 b: cdefg", 0],
            'invalid 2' => ["2-9 c: ccccccccc", 0],
            'one of two' => ["1-3 a: abcde\n1-3 b: cdefg", 1],
            'multi line - 2' => [self::PUZZLE_INPUT_MULTI_LINE, 1],
        ];
    }

    public function invalidInputProvider(): array
    {
        return [
            // negative tests
            'empty' => ['', InvalidInput::class, 'Empty input, please provide some data.'],
            'whitespace' => ["\t\r", InvalidInput::class, 'Incorrect input on line 1, please provide each line in format \'<min>-<max> <character>:<password>\'.'],
            'invalid data - text' => ['123abc', InvalidInput::class, 'Incorrect input on line 1, please provide each line in format \'<min>-<max> <character>:<password>\'.'],
            'invalid data - multiple lines' => ["1-3 a: abcde\n123abc", InvalidInput::class, 'Incorrect input on line 2, please provide each line in format \'<min>-<max> <character>:<password>\'.'],
            'min=0' => ["0-3 a: abcde", InvalidInput::class, 'pos1 must be between 1 and 99.'],
            'max=0' => ["1-0 a: abcde", InvalidInput::class, 'pos2 must be between 1 and 99.'],
            'min>max' => ["2-1 a: abcde", InvalidInput::class, 'pos2 must be greater than pos1.'],
        ];
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

    /**
     * @dataProvider inputOutputProvider
     */
    public function testSolution(string $input, int $output): void
    {
        $this->assertEquals($output, $this->part2->solution($input));
    }

    protected function setUp(): void
    {
        $this->part2 = new Part2();
    }
}
