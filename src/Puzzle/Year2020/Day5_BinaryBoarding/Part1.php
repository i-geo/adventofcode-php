<?php

/** @noinspection SpellCheckingInspection */

/*

--- Day 5: Binary Boarding ---
You board your plane only to discover a new problem: you dropped your boarding pass! You aren't sure which seat is yours, and all the flight attendants are busy with the flood of people that suddenly made it through passport control.

You write a quick program to use your phone's camera to scan all the nearby boarding passes (your puzzle input); perhaps you can find your seat through process of elimination.

Instead of zones or groups, this airline uses binary space partitioning to seat people. A seat might be specified like FBFBBFFRLR, where F means "front", B means "back", L means "left", and R means "right".

The first 7 characters will either be F or B; these specify exactly one of the 128 rows on the plane (numbered 0 through 127). Each letter tells you which half of a region the given seat is in. Start with the whole list of rows; the first letter indicates whether the seat is in the front (0 through 63) or the back (64 through 127). The next letter indicates which half of that region the seat is in, and so on until you're left with exactly one row.

For example, consider just the first seven characters of FBFBBFFRLR:

Start by considering the whole range, rows 0 through 127.
F means to take the lower half, keeping rows 0 through 63.
B means to take the upper half, keeping rows 32 through 63.
F means to take the lower half, keeping rows 32 through 47.
B means to take the upper half, keeping rows 40 through 47.
B keeps rows 44 through 47.
F keeps rows 44 through 45.
The final F keeps the lower of the two, row 44.
The last three characters will be either L or R; these specify exactly one of the 8 columns of seats on the plane (numbered 0 through 7). The same process as above proceeds again, this time with only three steps. L means to keep the lower half, while R means to keep the upper half.

For example, consider just the last 3 characters of FBFBBFFRLR:

Start by considering the whole range, columns 0 through 7.
R means to take the upper half, keeping columns 4 through 7.
L means to take the lower half, keeping columns 4 through 5.
The final R keeps the upper of the two, column 5.
So, decoding FBFBBFFRLR reveals that it is the seat at row 44, column 5.

Every seat also has a unique seat ID: multiply the row by 8, then add the column. In this example, the seat has ID 44 * 8 + 5 = 357.

Here are some other boarding passes:

BFFFBBFRRR: row 70, column 7, seat ID 567.
FFFBBBFRRR: row 14, column 7, seat ID 119.
BBFFBBFRLL: row 102, column 4, seat ID 820.
As a sanity check, look through your list of boarding passes. What is the highest seat ID on a boarding pass?


*/

namespace App\Puzzle\Year2020\Day5_BinaryBoarding;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\PuzzleInterface;

class Part1 implements PuzzleInterface
{
    private const WHITE_SPACE_CHARACTERS = ["\r", "\t"];
    private const NEW_LINE = "\n";

    private int $numberOfSeats = BoardingPass::MAX_NUM_PLANE_SEATS;

    /**
     * Finds the missing seat number
     *
     * @param mixed $input trees list
     *
     * @return int seat num
     * @throws InvalidInput
     */
    public function solution(mixed $input): int
    {
        $boardingPasses = $this->getBoardingPasses($input);
        return $this->findMissingBoardingPass($boardingPasses);
    }

    /**
     * @param int $numberOfSeats
     * @return void
     * @throws InvalidInput
     */
    public function setNumberOfSeats(int $numberOfSeats)
    {
        if ($numberOfSeats > BoardingPass::MAX_NUM_PLANE_SEATS) {
            throw new InvalidInput('Number of seats cannot be more than: ' . BoardingPass::MAX_NUM_PLANE_SEATS);
        }
        if ($numberOfSeats < BoardingPass::MIN_NUM_PLANE_SEATS) {
            throw new InvalidInput('Number of seats cannot be less than: ' . BoardingPass::MIN_NUM_PLANE_SEATS);
        }
        $this->numberOfSeats = $numberOfSeats;
    }

    /**
     * Validate and prepare data from input into expected format
     * @param mixed $input
     * @return BoardingPassesList
     * @throws InvalidInput
     */
    private function getBoardingPasses(mixed $input): BoardingPassesList
    {
        if (empty($input)) {
            return new BoardingPassesList();
        }

        // remove all whitespace characters
        $cleanData = str_replace(self::WHITE_SPACE_CHARACTERS, '', $input);

        // into array
        $data = explode(self::NEW_LINE, $cleanData);
        // ignore empty lines
        $data = array_filter($data);
        if (count($data) > $this->numberOfSeats) {
            throw new InvalidInput('Too many boarding passes for this plane, should be less than plane capacity: ' . $this->numberOfSeats);
        }
        if (count($data) === $this->numberOfSeats) {
            throw new InvalidInput('All seats are taken.');
        }

        $boardingPassesList = new BoardingPassesList();

        foreach ($data as $i => $datum) {
            $boardingPassIndex = $i + 1;
            try {
                $boardingPass = new BoardingPass($datum);
                $boardingPassesList->add($boardingPass);
            } catch (InvalidBoardingPass $e) {
                throw new InvalidInput("Boarding Pass $boardingPassIndex is invalid: {$e->getMessage()}." . PHP_EOL);
            }
        }

        return $boardingPassesList;
    }

    /**
     * Finds first missing pass
     * @param BoardingPassesList $boardingPasses
     * @return int
     */
    private function findMissingBoardingPass(BoardingPassesList $boardingPasses): int
    {
        $expectedNo = 1;
        foreach ($boardingPasses as $seatNo => $boardingPass) {
            $currentNo = $seatNo;
            if ($currentNo > $expectedNo) {
                break;
            }
            $expectedNo = $currentNo + 1;
        }

        return $expectedNo;
    }


}
