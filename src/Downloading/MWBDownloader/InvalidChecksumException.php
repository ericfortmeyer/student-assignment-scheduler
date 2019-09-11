<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

/**
 * @codeCoverageIgnore
 */
final class InvalidChecksumException extends \RuntimeException
{
    private const TYPE = "checksum";

    public function __construct(\Closure $messageFunc)
    {
        $this->message = $messageFunc(self::TYPE);
    }
}
