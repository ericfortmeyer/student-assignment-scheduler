<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

use \Ds\Vector;
use \DateTimeImmutable;

/**
 * Use to make sure that a valid month has been given
 * for downloading
 */
final class Month
{
    /**
     * @var DateTimeImmutable $month
     */
    private $month;

    /**
     * @var array $valid_month_formats
     */
    private $valid_month_formats = [
        "F",
        "M",
        "m",
        "n"
    ];

    /**
     * @var string $valid_to_string_month_format
     */
    private $dt_month_format = "m";

    private const FORMAT_FULL_TEXT = "F";
    private const FORMAT_NUMERIC = "m";

    /**
     * @param string $month
     * @throws InvalidMonthArgumentException
     */
    public function __construct(string $month)
    {
        $dt = DateTimeImmutable::createFromFormat($this->dt_month_format, $month);

        $valid_formats = new Vector($this->valid_month_formats);
        $dt = $valid_formats->reduce(
            function ($carry, string $dt_format) use ($month) {
                return is_a($carry, DateTimeImmutable::class)
                    ? $carry
                    : DateTimeImmutable::createFromFormat($dt_format, $month);
            }
        );

        if (!$dt) {
            throw new InvalidMonthArgumentException($month);
        } else {
            $this->month = $dt;
        }
    }

    public function __toString()
    {
        return $this->month->format(self::FORMAT_NUMERIC);
    }

    public function asText(): string
    {
        return $this->month->format(self::FORMAT_FULL_TEXT);
    }
}
