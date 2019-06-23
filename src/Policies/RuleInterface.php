<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Policies;

/**
 * Used to make logic an input to functions.
 *
 * Requires a context which is a map containing
 * key value pairs of things that will be tested.
 *
 */
interface RuleInterface
{
    public function result(): Result;
}
