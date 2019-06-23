<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
namespace StudentAssignmentScheduler;

use function StudentAssignmentScheduler\Utils\Functions\buildPath;

/**
 * The directory and filename of the persisted
 * SpecialEventHistory.
 *
 * Will produce a fullpath to the SpecialEventHistory
 * when cast to a string.
 */
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

    /**
     * Create the instance.
     *
     * @param Destination $destination
     * @param string $filename
     */
    public function __construct(Destination $destination, string $filename)
    {
        $this->destination = $destination;
        $this->filename = $filename;
    }

    /**
     * Use to cast the instance to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return buildPath((string) $this->destination, $this->filename);
    }
}
