<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Actions;

use \Closure;

final class Failure
{
    /**
     * @var Closure $action
     */
    private $action;

    public function __construct(Closure $action)
    {
        $this->action = $action;
    }

    public function __invoke($arg = null)
    {
        $closure = $this->action;
        return $closure($arg);
    }
}
