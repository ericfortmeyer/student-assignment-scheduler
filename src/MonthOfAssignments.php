<?php

namespace StudentAssignmentScheduler;

use \Ds\Map;

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

    public function __construct(array $schedule)
    {
        $Map = new Map($schedule);

        switch (false) {
            case $Map->hasKey(self::MONTH):
                throw new InvalidWeekOfAssignmentsArgumentException("key", self::MONTH);
            case $Map->hasKey(self::YEAR):
                throw new InvalidWeekOfAssignmentsArgumentException("key", self::YEAR);
        }

        $this->month = new Month($Map->remove(self::MONTH));
        $this->year = new Year($Map->remove(self::YEAR));

        $this->WeeksOfAssignments = new Map();

        $Map->apply(
            function (string $index, array $week_of_assignments) {
                $Week = new Map($week_of_assignments);

                $DayOfMonth = new DayOfMonth($this->month, $Week->remove(self::DATE));
                $Assignments = $Week->map(
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

    public function filter(\Closure $function): self
    {
        $weeks_before_filtering = $this->WeeksOfAssignments;
        $copy = clone $this;
        $copy->WeeksOfAssignments = $weeks_before_filtering->filter($function);
        return $copy;
    }

    public function weeks(): Map
    {
        return $this->WeeksOfAssignments;
    }

    public function month(): Month
    {
        return $this->month;
    }

    public function year(): Year
    {
        return $this->year;
    }

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
