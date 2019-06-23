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

    /**
     * Create the instance.
     *
     * @param Month $month
     * @param string $day_of_month
     */
    public function __construct(Month $month, string $day_of_month)
    {
        parent::__construct("${month}${day_of_month}");
    }
}
