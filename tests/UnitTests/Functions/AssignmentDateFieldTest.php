<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Policies\{
    AssignmentMonthFieldPolicy,
    Context
};

use StudentAssignmentScheduler\{
    Month,
    Date,
    DayOfMonth,
    Year,
    MonthOfAssignments
};

class AssignmentDateFieldTest extends TestCase
{
    public function testDateIsMovedToNextMonthWhenWeekOverlaps()
    {
        $given_month = new Month("April");
        $given_day_of_month = new DayOfMonth($given_month, "02");
        $given_year = new Year(2058);
        $mock_schedule = $this->mockSchedule(
            $given_year,
            $given_month->asText(),
            ["04", "11", "25", "02"]
        );

        $expected = "May 02";

        
        $actual = assignmentDateField(
            $given_day_of_month,
            new AssignmentMonthFieldPolicy(
                new MonthOfAssignments(
                    $mock_schedule
                ),
                new Date(
                    $given_month,
                    $given_day_of_month,
                    $given_year
                )
            )
        );
                
        $this->assertSame($expected, $actual);
    }
    
    public function testDateIsNotMovedToNextMonthWhenWeekDoesNotOverlap()
    {
        $given_month = new Month("April");
        $given_year = new Year(2058);
        $date_in_schedule = ["04", "11", "25", "02"];

        $mock_schedule = $this->mockSchedule(
            $given_year,
            $given_month->asText(),
            $date_in_schedule
        );
        
        array_map(
            function (string $given_day_of_month_string) use ($given_month, $given_year, $mock_schedule) {
                $expected = "{$given_month->asText()} $given_day_of_month_string";

                $given_day_of_month = new DayOfMonth($given_month, $given_day_of_month_string);

        
                $actual = assignmentDateField(
                    $given_day_of_month,
                    new AssignmentMonthFieldPolicy(
                        new MonthOfAssignments(
                            $mock_schedule
                        ),
                        new Date(
                            $given_month,
                            $given_day_of_month,
                            $given_year
                        )
                    )
                );
        
                $this->assertSame($expected, $actual);
            },
            array_filter(
                $date_in_schedule,
                function (string $key) {
                    //skip the final week
                    return $key < 3;
                },
                ARRAY_FILTER_USE_KEY
            )
        );
    }
    
    public function mockSchedule(string $given_year, string $given_month, array $dates_in_schedule): array
    {
        // only what's needed to test
        return [
            "year" => $given_year,
            "month" => $given_month,
            [ "date" => $dates_in_schedule[0] ],
            [ "date" => $dates_in_schedule[1] ],
            [ "date" => $dates_in_schedule[2] ],
            [ "date" => $dates_in_schedule[3] ],
        ];
    }
}
