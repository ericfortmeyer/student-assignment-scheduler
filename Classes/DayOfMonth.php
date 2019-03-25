<?php

namespace StudentAssignmentScheduler\Classes;

final class DayOfMonth extends DateType
{
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
