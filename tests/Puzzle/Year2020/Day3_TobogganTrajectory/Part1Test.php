<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Year2020\Day3_TobogganTrajectory\Part1;
use PHPUnit\Framework\TestCase;

class Part1Test extends TestCase
{
    private const PUZZLE_INPUT_MULTI_LINE = <<<'EOT'
        ..##.......
        #...#...#..
        .#....#..#.
        ..#.#...#.#
        .#...##..#.
        ..#.##.....
        .#.#.#....#
        .#........#
        #.##...#...
        #...##....#
        .#..#...#.#
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
            'zero-full' => ["....\n....", 0],
            'zero-short' => ["..\n..", 0],
            'one-1' => ["#...\n....", 1],
            'one-2' => ["....\n...#", 1],
            'two' => ["........\n...#....\n......#.", 2],
            'tree' => ["#.......\n...#....\n......#.", 3],
            'multi line - 7' => [self::PUZZLE_INPUT_MULTI_LINE, 7],
        ];
    }

    public function invalidInputProvider(): array
    {
        return [
            // negative tests
            'empty' => ['', InvalidInput::class, 'Empty input, please provide some data.'],
            'invalid map data' => ["..#X..", InvalidInput::class, 'Incorrect input on line 1, must be open squares (.) or trees (#).'],
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