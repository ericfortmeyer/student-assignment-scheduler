<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Utils;

final class InvalidUrlException extends \InvalidArgumentException
{
    public function __construct(string $errorMessage)
    {
        $this->message = "The url appears to be invalid.  $errorMessage";
    }
}
