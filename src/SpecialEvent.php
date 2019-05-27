<?php

namespace StudentAssignmentScheduler;

use \Ds\Vector;

use function StudentAssignmentScheduler\Functions\getConfig;

final class SpecialEvent
{
    /**
     * @var Date $date
     */
    private $date;

    /**
     * @var SpecialEventType $type
     */
    private $type;

    public function __construct(
        Date $date,
        SpecialEventType $type
    ) {
        $this->date = $date;
        $this->type = $type;
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

    public function type(): SpecialEventType
    {
        return $this->type;
    }

    public function date(): Date
    {
        return $this->date;
    }

    public function isPast(): bool
    {
        return $this->date->isPast();
    }
}
