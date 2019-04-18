<?php

namespace StudentAssignmentScheduler\Classes;

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
    protected $dt_format = "Y-M-d";


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
}
