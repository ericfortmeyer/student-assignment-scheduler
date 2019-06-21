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
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * The type of the event.
     *
     * @return EventType
     */
    public function type(): EventType
    {
        return $this->type;
    }

    /**
     * The date of the event.
     *
     * @return Date
     */
    public function date(): Date
    {
        return $this->date;
    }

    /**
     * Is the event in the past.
     *
     * @return bool
     */
    public function isPast(): bool
    {
        return $this->date->isPast();
    }
}
