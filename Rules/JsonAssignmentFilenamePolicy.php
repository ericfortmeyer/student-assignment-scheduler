<?php

namespace StudentAssignmentScheduler\Rules;

use StudentAssignmentScheduler\Classes\{
    Month,
    DayOfMonth,
};

use \DateTimeImmutable;
use \DateInterval;

final class JsonAssignmentFilenamePolicy extends AbstractRule
{
    /**
     * A map of values required to enforce the logic
     * represented by this class.
     * 
     * @var Context $context
     */
    protected $context;

    public const SCHEDULE_FOR_MONTH = "schedule_for_month",
                              MONTH = "month",
                       DAY_OF_MONTH = "day_of_month";
    
    /**
     * Schema of the Context object's key value pairs.
     * [schedule_for_month] Array representing the schedule for month.
     * [month] Month object.
     * [day_of_month] DayOfMonth object.
     */
    public const CONTEXT_REQUIREMENTS = [
        self::SCHEDULE_FOR_MONTH => [],
        self::MONTH => Month::class,
        self::DAY_OF_MONTH => DayOfMonth::class
    ];
    
    private const DATE_KEY = "date";

    public function __construct(Context $context)
    {
        if (!$this->monthIsAsExpected(
            $context[self::MONTH],
            $context[self::SCHEDULE_FOR_MONTH][self::MONTH])
        ) {
            $errorMessage = "The Context object [" . Context::class . "]"
                . " was given a schedule for month that is not compatible"
                . " with the month it was given.  The month field"
                . " in the schedule for month and the Month object are"
                . " expected to be the same values."
                . "Here is what was given:" . PHP_EOL
                . "Schedule for month -> " . $context[self::SCHEDULE_FOR_MONTH][self::MONTH]
                . "month value -> " . $context[self::MONTH];
            
            throw new \InvalidArgumentException($errorMessage);
        }

        parent::__construct($context);
    }

    /**
     * Determine which be in the filename.
     * 
     * A week can be ignored unless it overlaps two months.
     */
    public function result(): Result
    {

        $DayOfMonth = $this->context[self::DAY_OF_MONTH];
        $date = $this->dateInFirstWeekOfSchedule($this->context);
        $Month = $this->context[self::MONTH];

        return (
            $this->dayOfMonthIsNotInFirstWeek($DayOfMonth, $date)
                && $this->dayOfMonthIsLessThanDateInFirstWeek($DayOfMonth, $date)
        )
        
            ? $this->resultIfTrue($Month)
            : $this->resultIfFalse($Month);
    }

    private function resultIfTrue(Month $month): Result
    {
        return new Result(
            DateTimeImmutable::createFromFormat("m", $month)
                ->add(new DateInterval("P1M"))
                ->format("m")
        );
    }

    private function resultIfFalse(Month $month): Result
    {
        return new Result((string) $month);
    }

    private function dateInFirstWeekOfSchedule(Context $context): string
    {
        return $context[self::SCHEDULE_FOR_MONTH][0][self::DATE_KEY];
    }

    private function monthIsAsExpected(Month $value_in_context, string $value_in_schedule): bool
    {
        return (string) new Month($value_in_schedule) === (string) $value_in_context;
    }

    private function dayOfMonthIsNotInFirstWeek(DayOfMonth $DayOfMonth, string $date_in_first_week): bool
    {
        return (string) $DayOfMonth != $date_in_first_week;
    }

    private function dayOfMonthIsLessThanDateInFirstWeek(DayOfMonth $DayOfMonth, string $date_in_first_week): bool
    {
        return (string) $DayOfMonth < $date_in_first_week;
    }
}
