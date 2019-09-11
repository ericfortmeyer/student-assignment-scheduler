<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function testThrowsInvalidMonthArgumentException()
    {
        try {
            new Month("invalid string argument");
            $this->assertTrue(false); // test failed
        } catch (InvalidMonthArgumentException $e) {
            $this->assertTrue(true); // test passed
        }
    }

    public function testAsTextMethodReturnsExcpectedString()
    {
        $this->assertSame(
            "January",
            (new Month(1))->asText()
        );
        $this->assertSame(
            "January",
            (new Month("January"))->asText()
        );
    }
}
