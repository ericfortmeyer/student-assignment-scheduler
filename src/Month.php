<?php

namespace StudentAssignmentScheduler;

use \DateTimeImmutable;
use \DateInterval;

/**
 * Representation of a month in a date.
 *
 * Extracting this representation from dates is problematic.
 * Creating a date time instance from a month when the day of the month is not given
 * has produced unexpected results.  When tests are run on the 31st of the month and
 * the day of the month is not given, the instance will be created for the month
 * after the argument passed to the constructor.
 */
final class Month extends DateType implements ArrayInterface
{
    /**
     * @var string $error_message_example
     */
    protected static $error_message_example = "August, Aug, 08, or 8";

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

    private const FORMAT_FULL_TEXT = "F";

    /**
     * Full textual representation of the month.
     *
     * @return string
     */
    public function asText(): string
    {
        return (DateTimeImmutable::createFromFormat($this->dt_format . "d", $this->value . 1))
            ->format(self::FORMAT_FULL_TEXT);
    }

    /**
     * Immutability preserved when adding.
     *
     * @param int $num_months
     * @return Month
     */
    public function add(int $num_months): Month
    {
        return new Month(
            DateTimeImmutable::createFromFormat($this->dt_format . "d", $this->value . 1)
                ->add(new DateInterval("P${num_months}M"))
                ->format($this->dt_format)
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function getArrayCopy(): array
    {
        return [
            "href" => "2019" . (string) $this
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function exchangeArray($array): array
    {
        return $array;
    }
}
