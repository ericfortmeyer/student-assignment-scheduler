<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\DocumentProduction;

interface ScheduleWriterInterface
{
    /**
     * Create the schedule for the given month.
     *
     * Creates a file with the schedule for the given month that can be distrubted
     * i.e. a PDF file that can be attached to an email.
     *
     * @param object[] $assignments Array of objects representing assignments.
     * @param string[] $schedule Array of information about the schedule.
     * @param string $schedule_filename Name of the schedule.  Perhaps the month being scheduled.
     *
     * @return string Name of the file created.
     */
    public function create(array $assignments, array $schedule, string $schedule_filename): string;
}
