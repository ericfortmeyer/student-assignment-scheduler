<?php

namespace StudentAssignmentScheduler\Utils;

use StudentAssignmentScheduler\Classes\Actions\{
    Success,
    Failure
};

final class Selector
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function do(bool $test_result, Success $successAction, Failure $failureAction)
    {
        $selectedAction = $test_result ? $successAction : $failureAction;
        return $selectedAction();
    }
}
