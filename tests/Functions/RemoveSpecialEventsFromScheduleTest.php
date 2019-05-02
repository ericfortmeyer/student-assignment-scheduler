<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

use \Ds\Map;

use StudentAssignmentScheduler\Classes\{
    MonthOfAssignments,
    Destination,
    Date,
    Month,
    DayOfMonth,
    Year,
    SpecialEventType,
    SpecialEvent,
    SpecialEventHistory,
    SpecialEventHistoryLocation
};

class RemoveSpecialEventsFromScheduleTest extends TestCase
{
    protected function setup(): void
    {
        // we will have to create our own mocks here since
        // our test cases not having special events that are
        // in the past in comparison to the mock schedules
        $year = 2058;

        $assignment_name = "Talk";

        $this->schedules = new Map([
            new MonthOfAssignments([
                "year" => $year,
                "month" => "January",
                ["date" => 10, 5 => $assignment_name],
                ["date" => 17, 5 => $assignment_name],
                ["date" => 24, 5 => $assignment_name]
            ]),
            new MonthOfAssignments([
                "year" => $year,
                "month" => "October",
                ["date" => 4, 5 => $assignment_name],
                ["date" => 11, 5 => $assignment_name]
            ]),
            new MonthOfAssignments([
                "year" => $year,
                "month" => "November",
                ["date" => 8, 5 => $assignment_name],
                ["date" => 15, 5 => $assignment_name]
            ]),
            new MonthOfAssignments([
                "year" => $year,
                "month" => "December",
                ["date" => 6, 5 => $assignment_name],
                ["date" => 13, 5 => $assignment_name]
            ])
        ]);
    }

    public function testDatesWithSpecialEventsAreRemoved()
    {
        $allowed_special_event_types = getConfig()["special_events"];

        $empty_history = new SpecialEventHistory(
            new SpecialEventHistoryLocation(new Destination(__DIR__), "nonexistent")
        );

        $event_type = new SpecialEventType(
            $allowed_special_event_types,
            "Assembly"
        );

        [$january_event, $october_event, $november_event, $december_event] = [
            new SpecialEvent(
                new Date($jan = new Month(1),new DayOfMonth($jan, 10),new Year(2058)),
                $event_type
            ),
            new SpecialEvent(
                new Date($oct = new Month(10),new DayOfMonth($oct, 4),new Year(2058)),
                $event_type
            ),
            new SpecialEvent(
                new Date($nov = new Month(11),new DayOfMonth($nov, 8),new Year(2058)),
                $event_type
            ),
            new SpecialEvent(
                new Date($dec = new Month(12),new DayOfMonth($dec, 6),new Year(2058)),
                $event_type
            )
        ];

        $history_of_special_events = $empty_history
            ->add($january_event)
            ->add($november_event)
            ->add($october_event)
            ->add($december_event);



        $this->schedules->map(
            function ($key, MonthOfAssignments $schedule) use (
                $history_of_special_events,
                $january_event,
                $october_event,
                $november_event,
                $december_event
            ) {
                $history_of_special_events_copy = clone $history_of_special_events;

                $january = new Month(1);
                $october = new Month(10);
                $november = new Month(11);
                $december = new Month(12);
                
                $filtered_schedule = removeSpecialEventsFromSchedule(
                    $history_of_special_events_copy,
                    $schedule
                );

                $this->assertFalse(
                    $filtered_schedule === $schedule
                );

                $this->assertFalse(
                    $filtered_schedule->weeks()->isEmpty()
                );

                $this->assertFalse(
                    $filtered_schedule->weeks()->count() === $schedule->weeks()->count()
                );

                $containsDate = function (Date $date) {
                    return function ($carry, $value) use ($date) {
                        return $carry ? $carry : $value == $date;
                    };
                };

                switch ($filtered_schedule->month()) {
                    case $january:
                        $this->assertFalse(
                            $filtered_schedule->weeks()->keys()->reduce(
                                $containsDate($january_event->date())
                            )
                        );

                        $dateThatShouldBePresent = new Date(
                            $january,
                            new DayOfMonth(
                                $january,
                                17
                            ),
                            new Year(2058)
                        );
                        
                        $this->assertTrue(
                            $filtered_schedule->weeks()->keys()->reduce(
                                $containsDate($dateThatShouldBePresent)
                            )
                        );
                        break;

                    case $october:
                        $this->assertFalse(
                            $filtered_schedule->weeks()->keys()->reduce(
                                $containsDate($october_event->date())
                            )
                        );
                        break;

                    case $november:
                        $this->assertFalse(
                            $filtered_schedule->weeks()->keys()->reduce(
                                $containsDate($november_event->date())
                            )
                        );
                        break;

                    case $december:
                        $this->assertFalse(
                            $filtered_schedule->weeks()->keys()->reduce(
                                $containsDate($december_event->date())
                            )
                        );
                        break;
                }

            }
        );
    }
}
