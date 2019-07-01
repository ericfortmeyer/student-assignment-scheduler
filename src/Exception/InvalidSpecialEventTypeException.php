<?php

namespace StudentAssignmentScheduler\Exception;

final class InvalidSpecialEventTypeException extends \InvalidArgumentException
{
    public function __construct(string $argument, string $class, string $error_message_example)
    {
        $this->message = "It looks like '${argument}' is not a valid ${class}.  "
            . "Valid formats are ${error_message_example}.";
    }
}
