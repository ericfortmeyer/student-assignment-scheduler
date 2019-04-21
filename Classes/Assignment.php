<?php

namespace StudentAssignmentScheduler\Classes;

final class Assignment
{
    /**
     * @var string $name
     */
    private $name = "";

    /**
     * @var int $number
     */
    private $number = 0;

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
