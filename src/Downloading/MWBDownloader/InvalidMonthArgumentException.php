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

final class InvalidMonthArgumentException extends \InvalidArgumentException
{
    public function __construct(string $argument)
    {
        $this->message = "It looks like $argument is not a valid month."
            . PHP_EOL . "Valid formats are 'August', 'Aug', 08, 8.";
    }
}
