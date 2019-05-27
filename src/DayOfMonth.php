<?php

namespace StudentAssignmentScheduler;

final class DayOfMonth extends DateType
{
    /**
     * @var string $error_message_example
     */
    protected static $error_message_example = "01 or 1";

    /**
     * @var string $value
     */
    protected $value = "";

    /**
     * @var array $valid_formats
     */
    protected $valid_formats = [
        "Md",
        "MD",
        "mD",
        "md",
        "j",
        "z"
    ];

    /**
     * @var string $dt_format
     */
    protected $dt_format = "d";

    public function __construct(Month $month, string $day_of_month)
    {
        parent::__construct("${month}${day_of_month}");
    }
}
