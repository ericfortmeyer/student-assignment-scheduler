<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class AssignmentTest extends TestCase
{
    public function testAccessorMethodReturnExpectedValues()
    {
        $given_first_assignment = new Assignment("5", "Bible Reading");
        $given_second_assignment = new Assignment("6", "Talk");

        $this->assertSame(
            5,
            $given_first_assignment->number()
        );

        $this->assertSame(
            6,
            $given_second_assignment->number()
        );

        $this->assertSame(
            [6, "Talk"],
            $given_second_assignment->toArray()
        );

        $this->assertSame(
            "Bible Reading",
            (string) $given_first_assignment
        );
    }
}
