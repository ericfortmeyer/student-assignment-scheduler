<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

use \Ds\Map;

class WeekOfAssignmentsTest extends TestCase
{
    public function testAccessorMethodReturnExpectedValues()
    {
        $given_month = $expected_month = new Month("January");
        $given_day_of_month = $expected_day_of_month = new DayOfMonth($given_month, 12);
        $given_assignments = $expected_assignments = new Map([
            $given_first_assignment = new Assignment("5", "Bible Reading"),
            $given_second_assignment = new Assignment("6", "Talk")
        ]);

        $given_week_of_assignments = new WeekOfAssignments($given_month, $given_day_of_month, $given_assignments);

        $this->assertSame(
            $given_week_of_assignments->month(),
            $expected_month
        );

        $this->assertSame(
            $given_week_of_assignments->dayOfMonth(),
            $expected_day_of_month
        );

        $this->assertSame(
            $given_week_of_assignments->assignments(),
            $expected_assignments
        );

        $this->assertSame(
            $given_week_of_assignments->toArrayWithYearKey("2019"),
            [
                "year" => "2019",
                $given_first_assignment,
                $given_second_assignment
            ]
        );
    }
}
