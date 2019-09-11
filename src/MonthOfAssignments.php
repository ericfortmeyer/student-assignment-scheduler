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

use function StudentAssignmentScheduler\Utils\Functions\shouldMakeAssignment;
/**
 * A representation of all of the information needed
 * to make assignments for an entire month.
 */
final class MonthOfAssignments
{
    private const MONTH = "month",
                  DATE = "date",
                  YEAR  = "year";
    /**
     * @var Year $year
     */
    private $year;

    /**
     * @var Month $month
     */
    private $month;

    /**
     * @var Map $WeeksOfAssignments
     */
    private $WeeksOfAssignments;

    /**
     * Create a MonthOfAssignments instance
     */
    public function __construct(array $schedule)
    {
        $Map = new Map($schedule);

        switch (false) {
            case $Map->hasKey(self::MONTH):
                throw new Exception\InvalidWeekOfAssignmentsArgumentException("key", self::MONTH);
            case $Map->hasKey(self::YEAR):
                throw new Exception\InvalidWeekOfAssignmentsArgumentException("key", self::YEAR);
        }

        $this->month = new Month($Map->remove(self::MONTH));
        $this->year = new Year($Map->remove(self::YEAR));

        $this->WeeksOfAssignments = new Map();

        $Map->apply(
            function (string $index, array $week_of_assignments) {
                $Week = new Map($week_of_assignments);

                $DayOfMonth = new DayOfMonth($this->month, $Week->remove(self::DATE));
                $Assignments = $Week
                    ->filter(
                        function (string $assignment_number, string $assignment_name): bool {
                            return shouldMakeAssignment($assignment_name);
                        }
                    )->map(
                        function (string $assignment_number, string $assignment_name): Assignment {
                            return new Assignment($assignment_number, $assignment_name);
                        }
                    );

                $this->WeeksOfAssignments->put(
                    new Date(
                        $this->month,
                        $DayOfMonth,
                        $this->year
                    ),
                    new WeekOfAssignments($this->month, $DayOfMonth, $Assignments)
                );
            }
        );
    }

    /**
     * Create a new instance of MonthOfAssignments using
     * a Closure to determine which pairs to include.
     *
     * @param \Closure $function
     * @return self
     */
    public function filter(\Closure $function): self
    {
        $weeks_before_filtering = $this->WeeksOfAssignments;
        $copy = clone $this;
        $copy->WeeksOfAssignments = $weeks_before_filtering->filter($function);
        return $copy;
    }

    /**
     * A map of the assignments grouped by week.
     *
     * @return Map
     */
    public function weeks(): Map
    {
        return $this->WeeksOfAssignments;
    }

    /**
     * The month the assignments are in.
     *
     * @return Month
     */
    public function month(): Month
    {
        return $this->month;
    }

    /**
     * @codeCoverageIgnore
     */
    public function year(): Year
    {
        return $this->year;
    }

    /**
     * Use to cast the instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $assignmentAsString = function (string $key, Assignment $assignment) {
            return (string) $assignment;
        };

        $weekOfAssignmentToRequiredArrayFormat = function (WeekOfAssignments $week) use ($assignmentAsString) {
            return ["date" => (string) $week->dayOfMonth()]
                + $week->assignments()
                    ->map($assignmentAsString)
                    ->toArray();
        };

        return ["month" => $this->month->asText()]
            + ["year" => (string) $this->year]
            + $this->WeeksOfAssignments
                ->values()
                ->map($weekOfAssignmentToRequiredArrayFormat)
                ->toArray();
    }
}
