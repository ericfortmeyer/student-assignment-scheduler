<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

class MonthsFromScheduleFilenamesTest extends TestCase
{
    protected function setup(): void
    {
        $this->expected = array_filter(
            [
                ["month" => "January"],
                ["month" => "October"],
                ["month" => "November"],
                ["month" => "December"]
            ],
            function (array $arr) {
                return !isPastMonth($arr["month"]);
            }
        );
    }

    public function testReturnsExpectedMonths()
    {
        $this->assertSame(
            array_values($this->expected),
            monthsFromScheduleFilenames(__DIR__ . "/../../mocks/months")
        );
    }
}
