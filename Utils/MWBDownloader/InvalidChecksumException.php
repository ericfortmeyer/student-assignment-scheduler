<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader;

final class InvalidChecksumException extends \RuntimeException
{
    private const TYPE = "checksum";

    public function __construct(\Closure $messageFunc)
    {
        $this->message = $messageFunc(self::TYPE);
    }
}
