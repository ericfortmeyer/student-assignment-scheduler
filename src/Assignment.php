<?php

namespace StudentAssignmentScheduler;

/**
 * Represents information required to make an assignment.
 *
 * This instance does not represent an assignment
 * that has been made.
 */
final class Assignment
{
    /**
     * @var string $name Name of the assignment
     */
    public $name = "";

    /**
     * @var int $number The assignment number used in the schedule
     */
    public $number = 0;

    /**
     * @param string $number Will be converted to an int
     * @param string $name
     */
    public function __construct(string $number, string $name)
    {
        $this->number = (int) $number;
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            $this->number,
            $this->name
        ];
    }

    public function __toString()
    {
        return $this->name;
    }

    public function number(): int
    {
        return $this->number;
    }
}
