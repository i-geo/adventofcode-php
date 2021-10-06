<?php

namespace App\Puzzle\Year2020\Day5_BinaryBoarding;

class BoardingPass
{
    private const FRONT_CHAR = 'F';
    private const BACK_CHAR = 'B';
    private const FRONT_BIT = '0';
    private const BACK_BIT = '1';
    private const LEFT_CHAR = 'L';
    private const RIGHT_CHAR = 'R';
    private const LEFT_BIT = '0';
    private const RIGHT_BIT = '1';

    private const BOARDING_PASS_PATTERN =
        '/^(' .
        '[' . self::FRONT_CHAR . self::BACK_CHAR . ']{' . self::BINARY_PASS_ROW_LEN . '}' .
        '[' . self::LEFT_CHAR . self::RIGHT_CHAR . ']{' . self::BINARY_PASS_COL_LEN . '}' .
        ')$/';

    private const BINARY_PASS_ROW_LEN = 7;
    private const BINARY_PASS_COL_LEN = 3;
    private const BINARY_PASS_LEN = self::BINARY_PASS_ROW_LEN + self::BINARY_PASS_COL_LEN;
    private const BINARY_ROW_SEATS_COUNT = 8;//2 ^ self::BINARY_PASS_COL_LEN;

    public const MAX_NUM_PLANE_SEATS = 1024;
    public const MIN_NUM_PLANE_SEATS = 8;

    private int $row;
    private int $col;

    /**
     * @param string $binaryBoarding
     * @throws InvalidBoardingPass
     */
    public function __construct(string $binaryBoarding)
    {
        $this->decodeBinary($binaryBoarding);
    }

    /**
     * Decode binary boarding pass
     * @param string $binaryBoarding
     * @return void
     * @throws InvalidBoardingPass
     */
    private function decodeBinary(string $binaryBoarding)
    {
        if (strlen($binaryBoarding) !== self::BINARY_PASS_LEN) {
            throw new InvalidBoardingPass("Invalid length boarding pass: $binaryBoarding");
        }

        if (!preg_match(self::BOARDING_PASS_PATTERN, $binaryBoarding)) {
            throw new InvalidBoardingPass("Invalid format boarding pass: $binaryBoarding");
        }

        $rowBinary = substr($binaryBoarding, 0, self::BINARY_PASS_ROW_LEN);
        $this->row = $this->decodeRow($rowBinary);
        $colBinary = substr($binaryBoarding, self::BINARY_PASS_ROW_LEN, self::BINARY_PASS_COL_LEN);
        $this->col = $this->decodeCol($colBinary);
    }

    /**
     * Seat number calculated from row and column:
     * FBFBBFFRLR = row 44, column 5 => 44*8 + 5 = 357
     * @return int
     */
    public function seatNumber(): int
    {
        return ($this->row * self::BINARY_ROW_SEATS_COUNT) + $this->col + 1;
    }

    private function decodeRow(string $rowBinary): int
    {
        $rowBinary = str_replace(self::BACK_CHAR, self::BACK_BIT, $rowBinary);
        $rowBinary = str_replace(self::FRONT_CHAR, self::FRONT_BIT, $rowBinary);

        return bindec($rowBinary);
    }

    private function decodeCol(string $colBinary): int
    {
        $colBinary = str_replace(self::LEFT_CHAR, self::LEFT_BIT, $colBinary);
        $colBinary = str_replace(self::RIGHT_CHAR, self::RIGHT_BIT, $colBinary);

        return bindec($colBinary);
    }

}