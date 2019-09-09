<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

/**
 * @codeCoverageIgnore
 */
final class InvalidFilesizeException extends \RuntimeException
{
    private const TYPE = "file size";

    public function __construct(\Closure $messageFunc)
    {
        $this->message = $messageFunc(self::TYPE);
    }
}
