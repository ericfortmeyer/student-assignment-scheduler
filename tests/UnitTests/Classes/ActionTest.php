<?php

namespace StudentAssignmentScheduler\Classes\Actions;

use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    public function testActionsAreCallable()
    {
        $actions = new \Ds\Map([
            "I am a success" => new Success(function (): string {return "I am a success";}),
            "I am a failure" => new Failure(function (): string {return "I am a failure";})
        ]);

        $actions->apply(
            function (string $key, $action): void {
                $this->assertTrue(
                    \is_callable($action)
                );

                $this->assertSame(
                    $action(),
                    $key
                );
            }
        );
    }
}
