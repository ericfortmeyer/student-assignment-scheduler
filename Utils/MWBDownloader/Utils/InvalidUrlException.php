<?php

namespace StudentAssignmentScheduler\MWBDownloader\Utils;

final class InvalidUrlException extends \InvalidArgumentException
{
    public function __construct(string $url)
    {
        $this->message = "The url: $url appears to be invalid.";
    }
}
