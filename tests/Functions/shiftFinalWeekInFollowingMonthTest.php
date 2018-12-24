<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

class ShiftFinalWeekInFollowingMonthTest extends TestCase
{
    protected function setup()
    {
        $this->weeks_needing_shifting = [
            "1203.json",
            "1206.json",
            "1213.json",
            "1220.json",
            "1227.json"
        ];

        $this->weeks_not_needing_shifting = [
            "1108.json",
            "1115.json",
            "1122.json",
            "1129.json"
        ];
    }

    public function testShiftsFinalWeekAsExpected()
    {
        $result = shiftFinalWeekInFollowingMonth($this->weeks_needing_shifting);
        $first_element_before_shifting = $this->weeks_needing_shifting[0];
        $last_element_after_shifting = end($result);

        $this->assertThat(
            $first_element_before_shifting,
            $this->identicalTo(
                $last_element_after_shifting
            )
        );
    }

    public function testDoesNotShiftNormalMonth()
    {
        $result = shiftFinalWeekInFollowingMonth($this->weeks_not_needing_shifting);
        $first_element_before_shifting = $this->weeks_not_needing_shifting[0];
        $last_element_after_shifting = end($result);

        $this->assertThat(
            $first_element_before_shifting,
            $this->logicalNot(
                $this->identicalTo(
                    $last_element_after_shifting
                )
            )
        );
    }
}
