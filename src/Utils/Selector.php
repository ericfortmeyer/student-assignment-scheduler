<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Utils;

use StudentAssignmentScheduler\Actions\{
    Success,
    Failure
};

final class Selector
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }
    
    /**
     * @covers Failure::__invoke
     * @covers Success::__invoke
     */
    public static function do(bool $test_result, Success $successAction, Failure $failureAction)
    {
        $selectedAction = $test_result ? $successAction : $failureAction;
        return $selectedAction();
    }
}
