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
 * What kind of event it is.
 */
class EventType
{
    /**
     * @var string $type
     */
    protected $type = "";

    /**
     * Use to cast the instance to a string.
     */
    public function __toString()
    {
        return $this->type;
    }
}
