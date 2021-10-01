<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day2_PasswordPhilosophy;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Exceptions\NoSolution;
use App\Puzzle\Year2020\Day2_PasswordPhilosophy\Part1;
use PHPUnit\Framework\TestCase;

class Part1Test extends TestCase
{
    private const PUZZLE_INPUT_MULTI_LINE = <<<'EOT'
        1-3 a: abcde
        1-3 b: cdefg
        2-9 c: ccccccccc
        EOT;

    /**
     * Part 1.
     *
     * @var Part1
     */
    private Part1 $part1;

    public function inputOutputProvider(): array
    {
        return [
            // positive
            'zero' => ["1-3 b: cdefg", 0],
            'only one' => ["1-3 a: abcde", 1],
            'one of two' => ["1-3 a: abcde\n1-3 b: cdefg", 1],
            'multi line - 2' => [self::PUZZLE_INPUT_MULTI_LINE, 2],
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
            'min=0' => ["0-3 a: abcde", InvalidInput::class, 'min must be between 1 and 99.'],
            'max=0' => ["1-0 a: abcde", InvalidInput::class, 'max must be between 1 and 99.'],
            'min>max' => ["2-1 a: abcde", InvalidInput::class, 'max must be greater than min.'],
        ];
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testSolutionException(string $input, string $exceptionClass, string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $this->part1->solution($input);
    }

    /**
     * @dataProvider inputOutputProvider
     */
    public function testSolution(string $input, int $output): void
    {
        $this->assertEquals($output, $this->part1->solution($input));
    }

    protected function setUp(): void
    {
        $this->part1 = new Part1();
    }
}
