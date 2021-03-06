<?php

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
