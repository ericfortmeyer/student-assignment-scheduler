<?php

namespace StudentAssignmentScheduler\Classes;

final class Month extends DateType
{
    /**
     * @var string $value
     */
    protected $value = "";

    /**
     * @var array $valid_formats
     */
    protected $valid_formats = [
        "F",
        "M",
        "m",
        "n"
    ];

    /**
     * @var string $dt_format
     */
    protected $dt_format = "m";
}
