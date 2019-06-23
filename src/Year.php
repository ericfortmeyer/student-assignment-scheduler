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
 * Represents a year.
 */
final class Year extends DateType
{
    /**
     * @var string $error_message_example
     */
    protected static $error_message_example = "20 or 2020";

    /**
     * @var string $value
     */
    protected $value = "";

    /**
     * @var array $valid_formats
     */
    protected $valid_formats = [
        "Y",
        "y"
    ];

    /**
     * @var string $dt_format
     */
    protected $dt_format = "Y";

    /**
     * Immutability preserved when adding.
     *
     * @param int $num_years
     * @return Year
     */
    public function add(int $num_years): Year
    {
        return new Year(
            DateTimeImmutable::createFromFormat($this->dt_format, $this->value)
                ->add(new DateInterval("P${num_years}{$this->dt_format}"))
                ->format($this->dt_format)
        );
    }
}
