<?php

namespace StudentAssignmentScheduler\Classes;

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
     * @param int|string $value
     * @throws InvalidDateTypeArgumentException
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

    public function __toString()
    {
        return $this->value;
    }
}
