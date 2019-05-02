<?php

namespace StudentAssignmentScheduler\Rules;

use StudentAssignmentScheduler\Classes\{
    MonthOfAssignments,
    DayOfMonth,
    Month,
    Date
};

final class JsonAssignmentFilenamePolicy implements RuleInterface
{
    /**
     * @var MonthOfAssignments $schedule_for_month
     */
    private $schedule_for_month;

    /**
     * @var Date $date
     */
    private $date;

    public function __construct(MonthOfAssignments $schedule_for_month, Date $date)
    {
        $this->schedule_for_month = $schedule_for_month;
        $this->date = $date;
    }

    /**
     * Determine which be in the filename.
     *
     * A week can be ignored unless it overlaps two months.
     */
    public function result(): Result
    {
        $DayOfMonth = $this->date->dayOfMonth();
        $date = $this->dateInFirstWeekOfSchedule();
        $Month = $this->date->month();

        return $this->dayOfMonthIsLessThanDateInFirstWeek($DayOfMonth, $date)
            ? $this->resultIfTrue($Month)
            : $this->resultIfFalse($Month);
    }

    private function resultIfTrue(Month $month): Result
    {
        return new Result($month->add(1));
    }

    private function resultIfFalse(Month $month): Result
    {
        return new Result($month);
    }

    /**
     * @suppress PhanNonClassMethodCall
     */
    private function dateInFirstWeekOfSchedule(): string
    {
        return $this->schedule_for_month->weeks()->keys()->first()->dayOfMonth();
    }

    private function dayOfMonthIsLessThanDateInFirstWeek(DayOfMonth $DayOfMonth, string $date_in_first_week): bool
    {
        return (string) $DayOfMonth < $date_in_first_week;
    }
}
