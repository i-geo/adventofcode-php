<?php

namespace App\Service;

use App\Helper\ProjectPath;
use LogicException;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class PuzzleLocatorService
{
    /**
     * Puzzle directory relative path from root.
     *
     * @var string
     */
    private static $puzzleDirRelativePath = '/src/Puzzle';

    /**
     * Puzzle namespace prefix.
     *
     * @var string
     */
    private static $puzzleNamespacePrefix = 'App';

    /**
     * Puzzle year directory prefix.
     *
     * @var string
     */
    private static $yearPrefix = 'Year';

    /**
     * Gets class name for puzzle year, day and part if such exists.
     *
     * @param integer $year
     * @param integer $day
     * @param integer $part
     *
     * @throws LogicException If project root, puzzle directory, or specific puzzle cannot be found
     *
     * @return string
     */
    public function getPuzzleClassName(int $year, int $day, int $part): string
    {
        $puzzleFilepath = $this->getPuzzleFilepath($year, $day, $part);
        if ($puzzleFilepath === null) {
            throw new LogicException(sprintf(
                'Puzzle filepath from year "%s", day "%s" and part "%s" is not found.',
                $year,
                $day,
                $part
            ));
        }

        $puzzleFilepathArray = explode('/', $puzzleFilepath);
        $length = count($puzzleFilepathArray);

        $puzzleClassName = sprintf(
            '\%s\%s\%s\%s\%s',
            self::$puzzleNamespacePrefix,
            $puzzleFilepathArray[$length - 4],
            $puzzleFilepathArray[$length - 3],
            $puzzleFilepathArray[$length - 2],
            str_replace('.php', '', $puzzleFilepathArray[$length - 1])
        );

        if (!class_exists($puzzleClassName)) {
            throw new LogicException(sprintf(
                'Puzzle class for year "%s", day "%s" and part "%s" cannot be found.',
                $year,
                $day,
                $part
            ));
        }

        return $puzzleClassName;
    }

    /**
     * Gets filepath for puzzle year, day and part if such exists.
     *
     * @param integer $year
     * @param integer $day
     * @param integer $part
     *
     * @throws LogicException If project root or puzzle directory cannot be found
     *
     * @return string|null
     */
    private function getPuzzleFilepath(int $year, int $day, int $part): ?string
    {
        $projectPuzzleDir = $this->getProjectPuzzleDir();

        $yearDir = sprintf('%s/%s%s', $projectPuzzleDir, self::$yearPrefix, $year);
        // If puzzle year exists
        if (!file_exists($yearDir)) {
            return null;
        }

        $dayDirs = scandir($yearDir);
        $dayDir = null;

        foreach (is_array($dayDirs) ? $dayDirs : [] as $dirName) {
            if (preg_match('/Day([1-9]{1,2})/', $dirName, $matches)) {
                // If directory matches puzzle day
                if ($matches[1] == $day) {
                    $dayDir = sprintf('%s/%s', $yearDir, $dirName);
                    break;
                }
            }
        }

        if ($dayDir === null) {
            return null;
        }

        $partDirs = scandir($dayDir);
        $partDir = null;

        foreach (is_array($partDirs) ? $partDirs : [] as $dirName) {
            if (preg_match('/Part([1-2])/', $dirName, $matches)) {
                // If directory matches puzzle part
                if ($matches[1] == $part) {
                    $partDir = sprintf('%s/%s', $dayDir, $dirName);
                    break;
                }
            }
        }

        return $partDir;
    }

    /**
     * Runs puzzle with given path.
     *
     * @param string $puzzleClassName Puzzle class name
     * @param string $input Puzzle input
     *
     * @return string Puzzle output
     */
    public function runPuzzle(string $puzzleClassName, string $input): string
    {
        if (!class_exists($puzzleClassName)) {
            throw new InvalidArgumentException(sprintf(
                'Puzzle with class name "%s" does\'t exists.',
                $puzzleClassName
            ));
        }

        $puzzle = new $puzzleClassName();
        $output = $puzzle->solution($input);

        return (string) $output;
    }

    /**
     * Gets the project puzzle dir.
     *
     * @throws LogicException If project root or puzzle directory cannot be found
     *
     * @return string The project puzzle dir
     */
    private function getProjectPuzzleDir(): string
    {
        $projectRootDir = ProjectPath::getProjectRootDir();

        $projectPuzzleDir = $projectRootDir . self::$puzzleDirRelativePath;
        while (!file_exists($projectPuzzleDir)) {
            throw new LogicException('Project puzzle directory cannot be found.');
        }

        return $projectPuzzleDir;
    }
}
