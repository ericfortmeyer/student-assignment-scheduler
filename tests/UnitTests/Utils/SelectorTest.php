<?php

namespace StudentAssignmentScheduler\Utils;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Classes\Actions\{
    Success,
    Failure
};

class SelectorTest extends TestCase
{
    public function testCallsSuccessActionWhenFirstArgIsTrue()
    {
        $successAction = new Success(function () { return true; });
        $failureAction = new Failure(function () { return false; });

        $this->assertTrue(
            Selector::do(
                true,
                $successAction,
                $failureAction
            )
        );
    }
}
