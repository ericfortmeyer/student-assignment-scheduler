<?php

namespace StudentAssignmentScheduler;

/**
 * Represents an event in a schedule that
 * will be used in it's business logic.
 *
 * Has instances of Date and EventType as fields.
 */
class Event
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
        $this->date = $date;
        $this->type = $type;
    }

    public function type(): EventType
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
