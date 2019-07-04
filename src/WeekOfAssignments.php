<?php

namespace StudentAssignmentScheduler;

use \Ds\Map;

/**
 * Represents all of the information needed
 * to make assignments for a given week.
 */
final class WeekOfAssignments
{
    private const MONTH = "month",
                  DATE  = "date";
    /**
     * @var DayOfMonth $DayOfMonth
     */
    private $DayOfMonth;

    /**
     * @var Month $month
     */
    private $month;

    /**
     * @var Map $assignments
     */
    public $assignments;

    /**
     * Create a WeekOfAssignments instance.
     */
    public function __construct(Month $month, DayOfMonth $DayOfMonth, Map $assignments)
    {
        $this->month = $month;
        $this->DayOfMonth = $DayOfMonth;
        $this->assignments = $assignments;
    }

    public function assignments(): Map
    {
        return $this->assignments;
    }

    public function month(): Month
    {
        return $this->month;
    }

    public function dayOfMonth(): DayOfMonth
    {
        return $this->DayOfMonth;
    }

    public function toArrayWithYearKey(string $year): array
    {
        return ["year" => $year] + $this->assignments->toArray();
    }

    public function map(\Closure $callable): self
    {
        return new self(
            $this->month(),
            $this->dayOfMonth(),
            $this->assignments()->map($callable)
        );
    }
}
