<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;

class shiftFinalWeekInFollowingMonthTest extends TestCase
{
    protected function setup()
    {
        $this->weeks = [
            "1203.json",
            "1206.json",
            "1213.json",
            "1220.json",
            "1227.json"
        ];

        $this->normal_month = [
            "1108.json",
            "1115.json",
            "1122.json",
            "1129.json"
        ];
    }

    public function testShiftsFinalWeekAsExpected()
    {
        $result = shiftFinalWeekInFollowingMonth($this->weeks);
        $this->assertSame(
            $this->weeks[0],
            end($result)
        );
    }

    public function testDoesNotShiftNormalMonth()
    {
        $result = shiftFinalWeekInFollowingMonth($this->normal_month);

        $this->assertThat(
            $this->normal_month[0],
            $this->logicalNot(
                $this->identicalTo(
                    end($result)
                )
            )
        );
    }
}
