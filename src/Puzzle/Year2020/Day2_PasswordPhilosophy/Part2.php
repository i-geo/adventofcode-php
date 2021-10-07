<?php

/*
--- Day 2: Password Philosophy ---
Your flight departs in a few days from the coastal airport; the easiest way down to the coast from here is via toboggan.

The shopkeeper at the North Pole Toboggan Rental Shop is having a bad day. "Something's wrong with our computers; we can't log in!" You ask if you can take a look.

Their password database seems to be a little corrupted: some of the passwords wouldn't have been allowed by the Official Toboggan Corporate Policy that was in effect when they were chosen.

To try to debug the problem, they have created a list (your puzzle input) of passwords (according to the corrupted database) and the corporate policy when that password was set.

For example, suppose you have the following list:

1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
Each line gives the password policy and then the password. The password policy indicates the lowest and highest number of times a given letter must appear for the password to be valid. For example, 1-3 a means that the password must contain a at least 1 time and at most 3 times.

In the above example, 2 passwords are valid. The middle password, cdefg, is not; it contains no instances of b, but needs at least 1. The first and third passwords are valid: they contain one a or nine c, both within the limits of their respective policies.

How many passwords are valid according to their policies?

--- Part Two ---
While it appears you validated the passwords correctly, they don't seem to be what the Official Toboggan Corporate
Authentication System is expecting.

The shopkeeper suddenly realizes that he just accidentally explained the password policy rules from his old job
at the sled rental place down the street! The Official Toboggan Corporate Policy actually works a little differently.

Each policy actually describes two positions in the password, where 1 means the first character, 2 means the second
character, and so on. (Be careful; Toboggan Corporate Policies have no concept of "index zero"!) Exactly one of these
positions must contain the given letter. Other occurrences of the letter are irrelevant for the purposes of policy
enforcement.

Given the same example list from above:

1-3 a: abcde is valid: position 1 contains a and position 3 does not.
1-3 b: cdefg is invalid: neither position 1 nor position 3 contains b.
2-9 c: ccccccccc is invalid: both position 2 and position 9 contain c.
How many passwords are valid according to the new interpretation of the policies?

*/

namespace App\Puzzle\Year2020\Day2_PasswordPhilosophy;

use App\Puzzle\Exceptions\InvalidInput;
use App\Puzzle\PuzzleInterface;

class Part2 implements PuzzleInterface
{
    const WHITE_SPACE_CHARACTERS = ["\r", "\t"];
    const NEW_LINE = "\n";
    const LINE_FORMAT_REGEX = '/^(\d{1,2})-(\d{1,2}) ([\w]): ([\w].*)$/miu';

    /**
     * Finds how many passwords are valid according to their policies
     *
     * @param mixed $input Digits list
     *
     * @return int Sum
     * @throws InvalidInput
     */
    public function solution(mixed $input): int
    {
        $data = $this->prepareData($input);
        return $this->countValidPasswords($data);
    }

    /**
     * Validate and prepare data from input into expected format
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

        $prepared = [];
        foreach ($data as $i => $datum) {
            $prepared[] = $this->validateExtract($datum, $i + 1);
        }

        return $prepared;
    }

    /**
     * Find if each password matches policies
     * Expects prepared array
     * @param array $data
     * @return int
     * @throws InvalidInput
     */
    private function countValidPasswords(array $data): int
    {
        $count = 0;
        foreach ($data as $row) {
            $policy = new PasswordPolicy2($row['min'], $row['max'], $row['character']);
            $count += $this->policyMatch($policy, $row['password']);
        }
        return $count;
    }

    /**
     * Validates line data is according to rules.
     * Validation can be added to extraction to speed up
     * @param string $text
     * @param int $lineNum
     * @return array
     * @throws InvalidInput
     */
    private function validateExtract(string $text, int $lineNum): array
    {
        // Business Decision: Reject or ignore invalid lines?
        // For this exercise will reject on invalid
        if (preg_match(self::LINE_FORMAT_REGEX, $text, $match) !== 1) {
            /** @psalm-suppress */
            throw new InvalidInput("Incorrect input on line $lineNum, please provide each line in format '<min>-<max> <character>:<password>'.");
        }

        return [
            'min' => $match[1],
            'max' => $match[2],
            'character' => $match[3],
            'password' => $match[4],
        ];
    }

    /**
     * Checks if password matches policy
     * @param Policy $policy
     * @param string $password
     * @return int
     */
    private function policyMatch(Policy $policy, string $password): int
    {
        return ($policy->validPassword($password)) ? 1 : 0;
    }

}
