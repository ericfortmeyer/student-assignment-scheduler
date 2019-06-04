<?php

namespace StudentAssignmentScheduler;

/**
 * Information about an assignment
 */
final class Assignment
{
    /**
     * @var string $name Name of the assignment
     */
    private $name = "";

    /**
     * @var int $number The assignment number used in the schedule
     */
    private $number = 0;

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
