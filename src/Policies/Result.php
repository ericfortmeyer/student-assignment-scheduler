<?php

namespace StudentAssignmentScheduler\Policies;

final class Result
{
    /**
     * @var mixed $value
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function is()
    {
        return $this->value;
    }
}
