<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\BackupAndRestore;

use \Ds\{
    Set,
    Vector
};

class Directory
{
    /**
     * @var string $value
     */
    protected $value = "";

    public function __construct(string $directory)
    {
        $this->validateArg($directory);
        
        $this->value = $directory;
    }
    
    private function validateArg(string $arg): void
    {
        if (!is_dir($arg)) {
            throw new \InvalidArgumentException("${arg} is not a directory");
        }
    }

    public function __toString()
    {
        return $this->value;
    }

    public function files(): Set
    {
        return new Set(
            (new Vector(
                array_diff(
                    \scandir($this->value),
                    [".", "..", ".DS_Store"]
                )
            ))->map(
                function (string $basename): string {
                    return Functions\buildPath($this->value, $basename);
                }
            )
        );
    }
}
