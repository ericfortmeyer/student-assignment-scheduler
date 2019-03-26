<?php

namespace StudentAssignmentScheduler\Classes;

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
        "d",
        "j",
        "z"
    ];

    /**
     * @var string $dt_format
     */
    protected $dt_format = "d";
}
