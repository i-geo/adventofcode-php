<?php

/*

--- Day 3: Toboggan Trajectory ---
With the toboggan login problems resolved, you set off toward the airport. While travel by toboggan might be easy, it's certainly not safe: there's very minimal steering and the area is covered in trees. You'll need to see which angles will take you near the fewest trees.

Due to the local geology, trees in this area only grow on exact integer coordinates in a grid. You make a map (your puzzle input) of the open squares (.) and trees (#) you can see. For example:

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
These aren't the only trees, though; due to something you read about once involving arboreal genetics and biome stability, the same pattern repeats to the right many times:

..##.........##.........##.........##.........##.........##.......  --->
#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..
.#....#..#..#....#..#..#....#..#..#....#..#..#....#..#..#....#..#.
..#.#...#.#..#.#...#.#..#.#...#.#..#.#...#.#..#.#...#.#..#.#...#.#
.#...##..#..#...##..#..#...##..#..#...##..#..#...##..#..#...##..#.
..#.##.......#.##.......#.##.......#.##.......#.##.......#.##.....  --->
.#.#.#....#.#.#.#....#.#.#.#....#.#.#.#....#.#.#.#....#.#.#.#....#
.#........#.#........#.#........#.#........#.#........#.#........#
#.##...#...#.##...#...#.##...#...#.##...#...#.##...#...#.##...#...
#...##....##...##....##...##....##...##....##...##....##...##....#
.#..#...#.#.#..#...#.#.#..#...#.#.#..#...#.#.#..#...#.#.#..#...#.#  --->
You start on the open square (.) in the top-left corner and need to reach the bottom (below the bottom-most row on your map).

The toboggan can only follow a few specific slopes (you opted for a cheaper model that prefers rational numbers); start by counting all the trees you would encounter for the slope right 3, down 1:

From your starting position at the top-left, check the position that is right 3 and down 1. Then, check the position that is right 3 and down 1 from there, and so on until you go past the bottom of the map.

The locations you'd check in the above example are marked here with O where there was an open square and X where there was a tree:

..##.........##.........##.........##.........##.........##.......  --->
#..O#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..
.#....X..#..#....#..#..#....#..#..#....#..#..#....#..#..#....#..#.
..#.#...#O#..#.#...#.#..#.#...#.#..#.#...#.#..#.#...#.#..#.#...#.#
.#...##..#..X...##..#..#...##..#..#...##..#..#...##..#..#...##..#.
..#.##.......#.X#.......#.##.......#.##.......#.##.......#.##.....  --->
.#.#.#....#.#.#.#.O..#.#.#.#....#.#.#.#....#.#.#.#....#.#.#.#....#
.#........#.#........X.#........#.#........#.#........#.#........#
#.##...#...#.##...#...#.X#...#...#.##...#...#.##...#...#.##...#...
#...##....##...##....##...#X....##...##....##...##....##...##....#
.#..#...#.#.#..#...#.#.#..#...X.#.#..#...#.#.#..#...#.#.#..#...#.#  --->
In this example, traversing the map using this slope would cause you to encounter 7 trees.

Starting in the top-left corner of your map and following a slope of right 3 and down 1, how many trees would you encounter?

--- Part Two ---
Time to check the rest of the slopes - you need to minimize the probability of a sudden arboreal stop, after all.

Determine the number of trees you would encounter if, for each of the following slopes, you start at the top-left corner
and traverse the map all the way to the bottom:

Right 1, down 1.
Right 3, down 1. (This is the slope you already checked.)
Right 5, down 1.
Right 7, down 1.
Right 1, down 2.
In the above example, these slopes would find 2, 7, 3, 4, and 2 tree(s) respectively; multiplied together, these
produce the answer 336.

What do you get if you multiply together the number of trees encountered on each of the listed slopes?


*/

namespace App\Puzzle\Year2020\Day3_TobogganTrajectory;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\PuzzleInterface;

class Part2 implements PuzzleInterface
{
    private const TREE = '#';
    private const OPEN = '.';
    private const DOWN_START = 1;
    private const START_X = 0;
    private const START_Y = 0;
    private const RIGHT_LIST = [1, 3, 5, 7];

    private int $x = self::START_X;
    private int $y = self::START_Y;

    /**
     * Finds the sum of all digits that match the next digit in the circular list.
     *
     * @param mixed $input trees list
     *
     * @return float product of all encounters
     * @throws InvalidInput
     */
    public function solution(mixed $input): float
    {
        $treeMap = new TreeMap($input, self::OPEN, self::TREE);
        $down = self::DOWN_START;

        $hasEncounter = false;
        $product = 1;
        foreach (self::RIGHT_LIST as $right) {
            $this->encounterProduct($down, $right, $treeMap, $product, $hasEncounter);
        }
        $this->encounterProduct(2, 1, $treeMap, $product, $hasEncounter);

        return ($hasEncounter) ? $product : 0;
    }

    /**
     * @param int $x
     * @return Part2
     */
    public function setX(int $x): Part2
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @param int $y
     * @return Part2
     */
    public function setY(int $y): Part2
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @param int $down
     * @param int $right
     * @param TreeMap $treeMap
     * @return int
     * @throws InvalidInput
     */
    public function tobogganEncounter(int $down, int $right, TreeMap $treeMap): int
    {
        $toboggan = new Toboggan($down, $right);
        return $toboggan->countEncounters($treeMap, $this->x, $this->y);
    }

    /**
     * @param int $down
     * @param int $right
     * @param TreeMap $treeMap
     * @param int $product
     * @param bool $hasEncounter
     * @return void
     * @throws InvalidInput
     */
    public function encounterProduct(int $down, int $right, TreeMap $treeMap, int &$product, bool &$hasEncounter): void
    {
        $tobogganEncounter = $this->tobogganEncounter($down, $right, $treeMap);
        if ($tobogganEncounter > 0) {
            $hasEncounter = true;
            $product *= $tobogganEncounter;
        }
    }
}
