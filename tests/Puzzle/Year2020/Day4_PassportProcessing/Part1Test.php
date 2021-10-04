<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Puzzle\Year2020\Day4_PassportProcessing;

use App\Puzzle\Year2020\Day4_PassportProcessing\Part1;
use PHPUnit\Framework\TestCase;

class Part1Test extends TestCase
{
    private const PUZZLE_INPUT_MULTI_LINE = <<<'EOT'
        ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:1937 iyr:2017 cid:147 hgt:183cm
        iyr:2013 ecl:amb cid:350 eyr:2023 pid:028048884 hcl:#cfa07d byr:1929
        hcl:#ae17e1 iyr:2013 eyr:2024 ecl:brn pid:760753108 byr:1931 hgt:179cm
        hcl:#cfa07d eyr:2025 pid:166559648 iyr:2011 ecl:brn hgt:59in
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
            // negative tests
            'invalid - field name empty - 0' => [":123", 0],
            'invalid - field value missing - 0' => ["byr:", 0],
            'invalid - field separator missing - 0' => ["byr", 0],
            'invalid - field should be integer - 0' => ["byr:abc", 0],
            'invalid - missing Height - 0' => ["iyr:2013 ecl:amb cid:350 eyr:2023 pid:028048884 hcl:#cfa07d byr:1929", 0],
            'invalid - Birthday year too low - 0' => ["ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:100 iyr:2017 cid:147 hgt:183cm", 0],
            'invalid - Birthday year too high - 0' => ["ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:3000 iyr:2017 cid:147 hgt:183cm", 0],

            // positive tests
            'empty - 0' => ['', 0],
            'valid - 1' => ["ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:1937 iyr:2017 cid:147 hgt:183cm", 1],
            'valid - non mandatory - 1' => ["ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:1937 iyr:2017 hgt:183cm", 1],
            'multi line - 2' => [self::PUZZLE_INPUT_MULTI_LINE, 2],
        ];
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