<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;

class monthsFromScheduleFilenamesTest extends TestCase
{
    protected function setup()
    {
        $this->expected = array_filter(
            [
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
            monthsFromScheduleFilenames(__DIR__ . "/../mocks/months")
        );
    }
}
