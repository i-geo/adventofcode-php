<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\Year2020\Day3_TobogganTrajectory\Part2;
use PHPUnit\Framework\TestCase;

class Part2Test extends TestCase
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
     * Part 2.
     *
     * @var Part2
     */
    private Part2 $part2;

    public function inputOutputProvider(): array
    {
        return [
            // positive
            'zero-full' => ["....\n....", 0],
            'zero-short' => ["..\n..", 0],
            'one-1' => ["#...\n....", 1],
            'one-2' => ["....\n...#", 1],
            'two' => ["........\n.#.#....\n......#.", 2],
            '12' => ["#.......\n.#.#....\n......#.", 12],
            'multi line - 7' => [self::PUZZLE_INPUT_MULTI_LINE, 336],
        ];
    }

    public function invalidInputProvider(): array
    {
        return [
            // negative tests
            'empty' => ['', 0, 0, InvalidInput::class, 'Empty input, please provide some data.'],
            'invalid map data' => ["..#X..", 0, 0, InvalidInput::class, 'Incorrect input on line 1, must be open squares (.) or trees (#).'],
            'invalid start x' => ["....\n....", 10, 0, InvalidInput::class, 'Start x position cannot be larger than map width.'],
            'invalid start y' => ["....\n....", 0, 10, InvalidInput::class, 'Start y position cannot be larger than map height.'],
        ];
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testSolutionException(string $input, int $x, int $y, string $exceptionClass, string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $this->part2->setX($x)->setY($y);
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