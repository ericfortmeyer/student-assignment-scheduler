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

final class Result
{
    /**
     * @var mixed $value
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function is()
    {
        return $this->value;
    }
}
