<?php

namespace StudentAssignmentScheduler\Utils\Functions;

use PHPUnit\Framework\TestCase;

class RemoveYearKeyTest extends TestCase
{
    public function testYearKeyIsRemoved()
    {
        $given = [
            [
                "year" => 1970,
                "fake" => "array data"
            ]
        ];
        $expected = [
            ["fake" => "array data"]
        ];
        $this->assertSame(
            $expected,
            removeYearKey($given)
        );
    }
}
