<?php

namespace StudentAssignmentScheduler\Classes;

use \Ds\{
    Set,
    Vector
};

use function StudentAssignmentScheduler\Functions\buildPath;

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
            throw new \InvalidArgumentException("$arg is not a directory");
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
                    return buildPath($this->value, $basename);
                }
            )
        );
    }
}
