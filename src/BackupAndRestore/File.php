<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore;

final class File
{
    /**
     * @var string $filename
     */
    private $filename = "";
    
    public function __construct(string $filename)
    {
        if (!\file_exists($filename)) {
            throw new \RuntimeException(
                "File: ${filename} does not exist."
            );
        }

        $this->filename = $filename;
    }

    public function __toString()
    {
        return $this->filename;
    }
}
