<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Persistence;

interface Saveable
{
    /**
     * Stores the entity represented by the implementation.
     *
     * @param string $location Filename, key, or name depending on the implementation
     * @return void
     */
    public function save(string $location): void;
}
