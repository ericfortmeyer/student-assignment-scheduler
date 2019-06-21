<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Policies;

use StudentAssignmentScheduler\{
    MonthOfAssignments,
    Date,
    DayOfMonth,
    Month
};

final class AssignmentMonthFieldPolicy implements RuleInterface
{
    private $schedule_for_month;
    private $date;

    private const DATE_KEY = "date";
    private const MONTH_WORD_FORMAT = "M";

    public function __construct(MonthOfAssignments $schedule_for_month, Date $date)
    {
        $this->schedule_for_month = $schedule_for_month;
        $this->date = $date;
    }

    public function result(): Result
    {
        $DayOfMonth = $this->date->dayOfMonth();
        $date_in_first_week = $this->dateInFirstWeekOfSchedule();
        $Month = $this->date->month();

        return $this->dayOfMonthIsLessThanDateInFirstWeek($DayOfMonth, $date_in_first_week)
            ? $this->resultIfTrue($Month)
            : $this->resultIfFalse($Month);
    }
  
    private function resultIfTrue(Month $month): Result
    {
        return new Result($month->add(1)->asText());
    }

    private function resultIfFalse(Month $month): Result
    {
        return new Result($month->asText());
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
