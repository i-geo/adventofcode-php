<?php

namespace App\Helper;

use Symfony\Component\Console\Output\OutputInterface;

class CommandOutputHelper
{
    /**
     * Output exit error status code.
     */
    public const ERROR_CODE = 1;

    /**
     * Output exit success status code.
     */
    public const SUCCESS_CODE = 0;

    private const OUTPUT_HEADLINE_SEPARATOR = '================================================';

    public function getErrorOutput(OutputInterface $output, string $message): OutputInterface
    {
        $errorHeadline = 'Error';

        $output->writeln([
            '<error>' . $errorHeadline . '<error>',
            '<error>' . self::OUTPUT_HEADLINE_SEPARATOR . '<error>',
            '<error>' . $message . '<error>',
        ]);

        return $output;
    }

    public function getSuccessOutput(OutputInterface $output, string $message): OutputInterface
    {
        $outputHeadline = 'Output';

        $output->writeln([
            '<info>' . $outputHeadline . '<info>',
            '<info>' . self::OUTPUT_HEADLINE_SEPARATOR . '<info>',
            '<info>' . $message . '<info>',
        ]);

        return $output;
    }
}
