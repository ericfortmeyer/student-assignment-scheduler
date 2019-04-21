<?php

namespace StudentAssignmentScheduler\Classes;

use \DateTimeImmutable;

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
    protected $dt_format = "Y-m-d";


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

    public function isPast(): bool
    {
        return new DateTimeImmutable($this) < new DateTimeImmutable("00:00");
    }

    public function asText(): string
    {
        return "{$this->month->asText()} {$this->day_of_month}";
    }

    public function month(): Month
    {
        return $this->month;
    }

    public function dayOfMonth(): DayOfMonth
    {
        return $this->day_of_month;
    }

    public function year(): Year
    {
        return $this->year;
    }
}
