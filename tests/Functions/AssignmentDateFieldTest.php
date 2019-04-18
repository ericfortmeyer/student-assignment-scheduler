<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Rules\{
    AssignmentMonthFieldPolicy,
    Context
};

use StudentAssignmentScheduler\Classes\{
    Month,
    DayOfMonth
};

class AssignmentDateFieldTest extends TestCase
{
    public function testDateIsMovedToNextMonthWhenWeekOverlaps()
    {
        $given_month = "April";
        $given_day_of_month = "02";
        $mock_schedule = $this->mockSchedule(
            $given_month,
            ["04", "11", "25", "02"]
        );

        $expected = "May 02";

        
        $actual = assignmentDateField(
            new DayOfMonth(new Month($given_month), $given_day_of_month),
            new AssignmentMonthFieldPolicy(
                new Context([
                    AssignmentMonthFieldPolicy::SCHEDULE_FOR_MONTH => $mock_schedule,
                    AssignmentMonthFieldPolicy::MONTH => new Month($given_month),
                    AssignmentMonthFieldPolicy::DAY_OF_MONTH => new DayOfMonth(new Month($given_month), $given_day_of_month)
                ])
            )
        );
                
        $this->assertSame($expected, $actual);
    }
    
    public function testDateIsNotMovedToNextMonthWhenWeekDoesNotOverlap()
    {
        $given_month = "April";
        $date_in_schedule = ["04", "11", "25", "02"];

        $mock_schedule = $this->mockSchedule(
            $given_month,
            $date_in_schedule
        );
        
        array_map(
            function(string $given_day_of_month) use ($given_month, $mock_schedule) {
                $expected = "$given_month $given_day_of_month";
        
                $actual = assignmentDateField(
                    new DayOfMonth(new Month($given_month), $given_day_of_month),
                    new AssignmentMonthFieldPolicy(
                        new Context([
                            AssignmentMonthFieldPolicy::DAY_OF_MONTH => new DayOfMonth(new Month($given_month), $given_day_of_month),
                            AssignmentMonthFieldPolicy::SCHEDULE_FOR_MONTH => $mock_schedule,
                            AssignmentMonthFieldPolicy::MONTH => new Month($given_month)
                        ])
                    )
                );
        
                $this->assertSame($expected, $actual);
            },
            array_filter(
                $date_in_schedule,
                function(string $key) {
                    //skip the final week
                    return $key < 3;
                },
                ARRAY_FILTER_USE_KEY
            )
        );

    }
    
    public function mockSchedule(string $given_month, array $dates_in_schedule): array
    {
        // only what's needed to test
        return [
            "month" => $given_month,
            [ "date" => $dates_in_schedule[0] ],
            [ "date" => $dates_in_schedule[1] ],
            [ "date" => $dates_in_schedule[2] ],
            [ "date" => $dates_in_schedule[3] ],
        ];
    }
}
