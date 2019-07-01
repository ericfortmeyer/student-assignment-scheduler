<?php declare(strict_types=1);

namespace StudentAssignmentScheduler;

use \DateTimeImmutable;
use \DateTimeZone;
use \DateTimeInterface;

use StudentAssignmentScheduler\Exception\InvalidDateInputException;

/**
 * Extend DateTimeImmutable in order to use custom exception.
 */
final class ExtendedDateTimeImmutable extends DateTimeImmutable
{
    private const VALID_DATE_FORMATS = [
        DateTimeInterface::ATOM,
        DateTimeInterface::COOKIE,
        DateTimeInterface::ISO8601,
        DateTimeInterface::RFC1036,
        DateTimeInterface::RFC1123,
        DateTimeInterface::RFC2822,
        DateTimeInterface::RFC3339,
        DateTimeInterface::RFC3339_EXTENDED,
        DateTimeInterface::RFC7231,
        DateTimeInterface::RFC822,
        DateTimeInterface::RFC850,
        DateTimeInterface::RSS,
        DateTimeInterface::W3C,
        "Y/m/d"
    ];

    public function __construct(string $time = "now", ?DateTimeZone $timezone = null)
    {
        try {
            parent::__construct($time, $timezone);
        } catch (\Exception $e) {
            throw new InvalidDateInputException(
                sprintf(
                    "'%s' is not a valid date input.  Valid date inputs are: %s",
                    $time,
                    json_encode(self::VALID_DATE_FORMATS)
                )
            );
        }
    }
}
