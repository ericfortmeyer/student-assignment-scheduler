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

use StudentAssignmentScheduler\Exception\InvalidDateTypeArgumentException;
use \Ds\Vector;
use \DateTimeImmutable;

/**
 * Use to validate values representing date types
 */
abstract class DateType
{
    protected static $error_message_example = "";

    /**
     * @var string $value
     */
    protected $value = "";

    /**
     * @var array $valid_formats
     */
    protected $valid_formats = [];

    /**
     * @var string $dt_format
     */
    protected $dt_format = "";

    /**
     * Create the instance.
     *
     * @codeCoverageIgnore
     * @throws InvalidDateTypeArgumentException
     * @param int|string $value
     */
    public function __construct($value)
    {
        $dt = DateTimeImmutable::createFromFormat($this->dt_format, $value);

        $valid_formats = new Vector($this->valid_formats);
        $dt = $valid_formats->reduce(
            function ($carry, string $dt_format) use ($value) {
                return is_a($carry, DateTimeImmutable::class)
                    ? $carry
                    : DateTimeImmutable::createFromFormat($dt_format, $value);
            }
        );

        if (!$dt) {
            throw new InvalidDateTypeArgumentException(
                $value,
                static::class,
                static::$error_message_example
            );
        } else {
            $this->value = $dt->format(
                $this->dt_format
            );
        }
    }

    /**
     * Use to cast this instance to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
