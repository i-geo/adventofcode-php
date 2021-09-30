<?php

namespace App\Helper;

use LogicException;

class ProjectPath
{
    /**
     * Gets the project root dir (path of the project's composer file).
     *
     * @throws LogicException If project root directory cannot be found
     *
     * @return string The project root dir
     */
    public static function getProjectRootDir(): string
    {
        $dir = __DIR__;

        // Climbing the directory tree until composer.json is found
        while (!file_exists($dir . '/composer.json')) {
            if ($dir === '/') {
                throw new LogicException('Project root directory cannot be found.');
            }

            $dir = dirname($dir);
        }

        return $dir;
    }
}
