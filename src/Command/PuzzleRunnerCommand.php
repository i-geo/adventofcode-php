<?php

namespace App\Command;

use App\Helper\CommandOutputHelper;
use App\Service\PuzzleLocatorService;
use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PuzzleRunnerCommand extends Command
{
    protected static $defaultName = 'puzzle:run';

    /**
     * Command output helper.
     *
     * @var CommandOutputHelper $commandOutputHelper
     */
    private CommandOutputHelper $commandOutputHelper;

    /**
     * Puzzle locator service.
     *
     * @var PuzzleLocatorService $puzzleLocatorService
     */
    private PuzzleLocatorService $puzzleLocatorService;

    public function __construct()
    {
        $this->commandOutputHelper = new CommandOutputHelper();
        $this->puzzleLocatorService = new PuzzleLocatorService();

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Advent of code puzzle runner.')
            ->addArgument('year', InputArgument::REQUIRED, 'Puzzle year')
            ->addArgument('day', InputArgument::REQUIRED, 'Puzzle day')
            ->addArgument('part', InputArgument::REQUIRED, 'Puzzle part')
            ->addArgument('puzzle_input', InputArgument::REQUIRED, 'Puzzle input');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = $input->getArgument('year');
        if (!filter_var($year, FILTER_VALIDATE_INT)) {
            $this->commandOutputHelper->getErrorOutput(
                $output,
                sprintf('Puzzle year "%s" is not valid integer.', $year)
            );
            return CommandOutputHelper::ERROR_CODE;
        }
        $year = (int) $year;

        $day = $input->getArgument('day');
        if (!filter_var($day, FILTER_VALIDATE_INT)) {
            $this->commandOutputHelper->getErrorOutput(
                $output,
                sprintf('Puzzle day "%s" is not valid integer.', $day)
            );
            return CommandOutputHelper::ERROR_CODE;
        }
        $day = (int) $day;

        $part = $input->getArgument('part');
        if (!filter_var($part, FILTER_VALIDATE_INT)) {
            $this->commandOutputHelper->getErrorOutput(
                $output,
                sprintf('Puzzle part "%s" is not valid integer.', $part)
            );
            return CommandOutputHelper::ERROR_CODE;
        }
        $part = (int) $part;

        $puzzleInput = $input->getArgument('puzzle_input');

        try {
            $puzzleClassName = $this->puzzleLocatorService->getPuzzleClassName($year, $day, $part);
            $puzzleOutput = $this->puzzleLocatorService->runPuzzle($puzzleClassName, $puzzleInput);
        } catch (LogicException $e) {
            $this->commandOutputHelper->getErrorOutput($output, $e->getMessage());
            return CommandOutputHelper::ERROR_CODE;
        }

        $this->commandOutputHelper->getSuccessOutput($output, $puzzleOutput);
        return CommandOutputHelper::SUCCESS_CODE;
    }
}
