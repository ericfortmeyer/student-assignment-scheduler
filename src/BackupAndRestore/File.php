<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore;

use \InvalidArgumentException;

final class File
{
    /**
     * @var string $filename
     */
    private $filename = "";
    
    /**
     * Create the instance.
     * 
     * @throws InvalidArgumentException
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        if (!\file_exists($filename)) {
            throw new InvalidArgumentException(
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
