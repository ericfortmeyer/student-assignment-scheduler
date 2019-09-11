<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
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

    /**
     * Returns the assignments.
     *
     * @return Map
     */
    public function assignments(): Map
    {
        return $this->assignments;
    }

    /**
     * Returns the month the assignments are in.
     *
     * @return Month
     */
    public function month(): Month
    {
        return $this->month;
    }

    /**
     * Returns the day of the month used
     * to reference the week the assignments
     * are in.
     *
     * @return DayOfMonth
     */
    public function dayOfMonth(): DayOfMonth
    {
        return $this->DayOfMonth;
    }

    /**
     * Use to cast the instance to an array
     * with the given year added to the
     * returned array.
     *
     * @param string $year
     * @return array
     */
    public function toArrayWithYearKey(string $year): array
    {
        return ["year" => $year] + $this->assignments->toArray();
    }

    /**
     * @codeCoverageIgnore
     */
    public function map(\Closure $callable): self
    {
        return new self(
            $this->month(),
            $this->dayOfMonth(),
            $this->assignments()->map($callable)
        );
    }
}
