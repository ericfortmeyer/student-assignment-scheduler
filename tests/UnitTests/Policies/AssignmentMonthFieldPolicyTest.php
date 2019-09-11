<?php

namespace StudentAssignmentScheduler\Policies;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\{
    Month,
    DayOfMonth,
    Year,
    Date,
    MonthOfAssignments
};

class AssignmentMonthFieldPolicyTest extends TestCase
{
    protected function setUp(): void
    {
        // since it the last week overlaps with the following week we will use
        // 2018/12
        $this->fake_schedule = [
            "month" => "December",
            "year" => "2018",
            0 => [
                "date" => "06",
                5 => "First Conversation Video",
                6 => "First Return Visit",
                7 => "Bible Study"
            ],
            1 => [
                "date" => "13",
                5 => "First Conversation",
                6 => "First Return Visit Video",
                7 => "Talk"
            ],
            2 => [
                "date" => "20",
                5 => "First Conversation",
                6 => "First Return Visit",
                7 => "Second Return Visit Video"
            ],
            3 => [
                "date" => "27",
                5 => "Second Return Visit",
                6 => "Third Return Visit",
                7 => "Bible Study"
            ],
            4 => [
                "date" => "03",
                5 => "Second Return Visit",
                6 => "Third Return Visit",
                7 => "Bible Study"
            ]
        ];
    }

    public function testComputedMonthFieldIsAsExpectedWhenDayOfMonthFallsOnOverlappingWeek()
    {
        $expected_month_field = "January";
        $given_month = new Month("December");
        $day_of_month_on_overlapping_week = new DayOfMonth($given_month, "03");
        $given_year = new Year(2018);
        $computedMonthField = (new AssignmentMonthFieldPolicy(
            new MonthOfAssignments($this->fake_schedule),
            new Date(
                $given_month,
                $day_of_month_on_overlapping_week,
                $given_year
            )
        ))->result()->is();
        $this->assertSame(
            $expected_month_field,
            $computedMonthField
        );
    }

    public function testComputedMonthFieldIsAsExpectedWhenDayOfMonthMonthDoesNotFallOnOverlappingWeek()
    {
        $expected_month_field = "December";
        $given_month = new Month("December");
        $day_of_month_not_on_overlapping_week = new DayOfMonth($given_month, "06");
        $given_year = new Year(2018);
        $computedMonthField = (new AssignmentMonthFieldPolicy(
            new MonthOfAssignments($this->fake_schedule),
            new Date(
                $given_month,
                $day_of_month_not_on_overlapping_week,
                $given_year
            )
        ))->result()->is();
        $this->assertSame(
            $expected_month_field,
            $computedMonthField
        );
    }
}
