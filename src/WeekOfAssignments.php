<?php

namespace StudentAssignmentScheduler;

use \Ds\Map;

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
    private $assignments;

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
}
