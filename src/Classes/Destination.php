<?php

namespace StudentAssignmentScheduler\Classes;

class Destination
{
    /**
     * @var string $value
     */
    protected $value = "";

    public function __construct(string $destination)
    {
        $this->validateArg($destination);
        
        $this->value = $destination;
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
}
