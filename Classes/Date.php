<?php

namespace StudentAssignmentScheduler\Classes;

use \DateTimeImmutable;
use \DateInterval;

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

    public function sub(int $days_to_subtract): self
    {
        $newDate = DateTimeImmutable::createFromFormat($this->dt_format, (string) $this)
            ->sub(new DateInterval("P${days_to_subtract}D"));
        
        return new self(
            $Month = new Month($newDate->format("m")),
            new DayOfMonth($Month, $newDate->format("d")),
            new Year($newDate->format("Y"))
        );
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
