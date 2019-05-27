<?php

namespace StudentAssignmentScheduler;

use function StudentAssignmentScheduler\Functions\buildPath;

final class SpecialEventHistoryLocation
{
    /**
     * @var Destination $destination
     */
    private $destination;

    /**
     * @var string $filename Location of history
     */
    private $filename = "";

    public function __construct(Destination $destination, string $filename)
    {
        $this->destination = $destination;
        $this->filename = $filename;
    }

    public function __toString()
    {
        return buildPath($this->destination, $this->filename);
    }
}
