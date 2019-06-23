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
final class SpecialEvent extends Event
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
     * Create the instance.
     *
     * @param Date $date
     * @param EventType $type
     */
    public function __construct(
        Date $date,
        EventType $type
    ) {
        parent::__construct($date, $type);
    }

    /**
     * Use to cast the instance to a string.
     *
     * @return string
     */
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

        $typeAsString = (string) $this->type;
        $dateAsString = (string) $this->date;

        $eventAsString = $prepend($typeAsString) . $append($dateAsString);
        $currentLen = strlen($eventAsString);

        $tabWidth = $maxLen - $currentLen + 1;
        $whitespace = ' ';


        $tab = str_pad($whitespace, (int) $tabWidth, $whitespace);

        return "{$prepend($typeAsString)}${tab}{$append($dateAsString)}";
    }

    /**
     * Use to make the instance serializable to JSON.
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            "date" => (string) $this->date(),
            "type" => (string) $this->type()
        ];
    }
}
