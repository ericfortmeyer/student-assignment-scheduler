<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler;

use \Ds\Vector;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

/**
 * Represents an event that would a meeting cancellation.
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

    public function __construct(
        Date $date,
        EventType $type
    ) {
        parent::__construct($date, $type);
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
                return strlen($prepend($event) . $append($this->date));
            })->toArray()
        );

        $eventAsString = $prepend($this->type) . $append($this->date);
        $currentLen = strlen($eventAsString);

        $tabWidth = $maxLen - $currentLen + 1;
        $whitespace = ' ';


        $tab = str_pad($whitespace, (int) $tabWidth, $whitespace);

        return "{$prepend($this->type)}${tab}{$append($this->date)}";
    }
}
