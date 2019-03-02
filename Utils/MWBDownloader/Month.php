<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader;

use \Ds\Vector;
use \DateTimeImmutable;

/**
 * Use to make sure that a valid month has been given
 * for downloading
 */
final class Month
{
    /**
     * @var string $month
     */
    private $month = "";

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
            $this->month = $dt->format(
                $this->dt_month_format
            );
        }
    }

    public function __toString()
    {
        return $this->month;
    }
}
