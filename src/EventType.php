<?php

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

    public function __toString()
    {
        return $this->type;
    }
}
