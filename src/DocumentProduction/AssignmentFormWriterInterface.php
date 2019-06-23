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

interface AssignmentFormWriterInterface
{
    public function create(string $assignment_number, array $data, string $basename_of_target_file_with_ext): void;
}
