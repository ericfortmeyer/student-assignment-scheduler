<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Exception;

final class InvalidMonthArgumentException extends \InvalidArgumentException
{
    public function __construct(string $argument)
    {
        $this->message = "It looks like $argument is not a valid month."
            . PHP_EOL . "Valid formats are 'August', 'Aug', 08, 8.";
    }
}
