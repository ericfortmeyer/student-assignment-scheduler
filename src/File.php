<?php declare(strict_types=1);

namespace StudentAssignmentScheduler;

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
