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

use \Ds\Vector;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

/**
 * Represents an event that would cause a meeting cancellation.
 *
 * Has instances of Date and EventType as fields and
 * can be cast to a string.
 */
final class SpecialEvent extends Event implements ArrayInterface
{
    /**
     * @var Date $date
     */
    protected $date;

    /**
     * @var EventType $type
     */
    protected $type;

    /**
     * @var Guid $guid
     */
    protected $guid;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        Date $date,
        EventType $type,
        ?Guid $guid = null
    ) {
        $this->guid = $guid ?? new Guid();
        parent::__construct($date, $type);
    }

    public function guid(): Guid
    {
        return $this->guid;
    }

    public function __toString()
    {
        $special_events = getConfig()["special_events"];
        $prepend = function (string $type) {
            return "{$type}: ";
        };
        $append = function (string $date) {
            return " {$date}" . PHP_EOL;
        };
        $maxLen = max(
            (new Vector($special_events))->map(function (string $event) use ($prepend, $append): int {
                return strlen($prepend((string) $event) . $append((string) $this->date));
            })->toArray()
        );
        $eventAsString = $prepend((string) $this->type) . $append((string) $this->date);
        $currentLen = strlen($eventAsString);
        $tabWidth = $maxLen - $currentLen + 1;
        $whitespace = ' ';
        $tab = str_pad($whitespace, (int) $tabWidth, $whitespace);
        return "{$prepend((string) $this->type)}${tab}{$append((string) $this->date)}";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getArrayCopy(): array
    {
        return [
            "id" => (string) $this->guid(),
            "date" => (string) $this->date()->toISOString(),
            "type" => str_replace(
                " ",
                "_",
                (string) $this->type()
            )
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function exchangeArray($array): array
    {
        return (array) $array;
    }
}
