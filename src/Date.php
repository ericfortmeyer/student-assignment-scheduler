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

use \DateTimeImmutable;
use \DateInterval;

/**
 * Represents a date.
 */
final class Date extends DateType
{
    /**
     * @var string $value
     */
    protected $value = "";

    /**
     * @var Month $month
     */
    private $month;

    /**
     * @var DayOfMonth $day_of_month
     */
    private $day_of_month;

    /**
     * @var Year $year
     */
    private $year;

    /**
     * @var array $valid_formats
     */
    protected $valid_formats = [
        "Y-M-d",
        "Y-M-D",
        "Y-m-d",
        "Y/M/d",
        "Y/m/d",
        "Y/M/D",
        "YMD",
        "YMd",
        "Ymd",
        "z",
        "c",
        "r",
        "u"
    ];

    /**
     * @var string $dt_format
     */
    protected $dt_format = "Ymd";

    /**
     * Creates a Date instance.
     *
     * @param Month $month
     * @param DayOfMonth $day_of_month
     * @param Year $year
     */
    public function __construct(
        Month $month,
        DayOfMonth $day_of_month,
        Year $year
    ) {
        $this->month = $month;
        $this->day_of_month = $day_of_month;
        $this->year = $year;

        $params_as_string = "${year}-${month}-${day_of_month}";

        parent::__construct($params_as_string);
    }

    /**
     * Returns whether the date is in the past.
     *
     * @return bool
     */
    public function isPast(): bool
    {
        return new DateTimeImmutable($this) < new DateTimeImmutable("00:00");
    }

    /**
     * Creates a date with the number of days provided subtracted.
     *
     * @param int $number_of_days Number of days to subtract
     * @return self
     */
    public function sub(int $number_of_days): self
    {
        $newDate = DateTimeImmutable::createFromFormat($this->dt_format, (string) $this)
            ->sub(new DateInterval("P${number_of_days}D"));
        
        return new self(
            $Month = new Month($newDate->format("m")),
            new DayOfMonth($Month, $newDate->format("d")),
            new Year($newDate->format("Y"))
        );
    }

    /**
     * Use to create a textual representation of the date.
     *
     * @return string
     */
    public function asText(): string
    {
        return "{$this->month->asText()} {$this->day_of_month}";
    }

    /**
     * The representation of the date's month.
     *
     * @return Month
     */
    public function month(): Month
    {
        return $this->month;
    }

    /**
     * The representation of the date's day of the month.
     *
     * @return DayOfMonth
     */
    public function dayOfMonth(): DayOfMonth
    {
        return $this->day_of_month;
    }

    /**
     * The representation of the date's year.
     *
     * @return Year
     */
    public function year(): Year
    {
        return $this->year;
    }
}
