<?php

namespace StudentAssignmentScheduler\Classes;

use \Ds\Vector;
use \DateTimeImmutable;

/**
 * Use to validate values representing date types
 */
abstract class DateType
{
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
     * @param string $value
     * @throws InvalidMonthArgumentException
     */
    public function __construct(string $value)
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
            throw new InvalidMonthArgumentException($value);
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
