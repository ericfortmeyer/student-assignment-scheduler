<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

final class InvalidMimetypeException extends \RuntimeException
{
    public function __construct(string $class, string $expected, string $actual)
    {
        $this->message = "An attempt was made to create an instance of $class which "
            . "expects a mimetype of $expected but received $actual instead.";
    }
}
