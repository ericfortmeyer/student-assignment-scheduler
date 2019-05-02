<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

use \Ds\Map;

use function StudentAssignmentScheduler\Functions\importJson;

class MonthOfAssignmentsTest extends TestCase
{
    protected function setup(): void
    {
        $year = "2058";
        $assignment_name = "Talk";

        $this->valid_data = [
            "year" => $year,
            "month" => "January",
            ["date" => 10, 5 => $assignment_name],
            ["date" => 17, 5 => $assignment_name],
            ["date" => 24, 5 => $assignment_name]
        ];

        $this->MonthOfAssignments = new MonthOfAssignments([
            "year" => $year,
            "month" => "January",
            ["date" => 10, 5 => $assignment_name],
            ["date" => 17, 5 => $assignment_name],
            ["date" => 24, 5 => $assignment_name]
        ]);

        $this->invalid_data = json_decode(
            \file_get_contents(__DIR__ . "/../mocks/0131.json"),
            true
        );
    }

    public function testAccessorMethodReturnExpectedValues()
    {
        $expected_month = new Month("January");
        $expected_day_of_month = new DayOfMonth($expected_month, 31);
        $expected_assignments = new Map([
            "4" => [
                "date" => "January 31",
                "assignment" => "bible_reading",
                "name" => "Forrest Gump",
                "counsel_point" => "",
                "assistant" => ""
            ],
            "6" => [
                "date" => "January 31",
                "assignment" => "Second Return Visit",
                "name" => "Donny Hathaway",
                "counsel_point" => "",
                "assistant" => "Art Tatum"
            ],
            "7" => [
                "date" => "January 31",
                "assignment" => "Bible Study",
                "name" => "Jeremiah Bullfrog",
                "counsel_point" => "",
                "assistant" => "Joy to the world"
            ]
        ]);

        $expected_week_of_assignments = new WeekOfAssignments(
            $expected_month,
            $expected_day_of_month,
            $expected_assignments
        );

        $expected_weeks = new Map([$expected_week_of_assignments]);

        $this->assertEquals(
            $this->MonthOfAssignments->month(),
            $expected_month
        );

        $this->assertEquals(
            $this->MonthOfAssignments->weeks(),
            $expected_weeks
        );
    }

    public function testThrowsInvalidWeekOfAssignmentsArgumentException()
    {
        (new \Ds\Vector(["month", "year"]))
            ->apply(
                function (string $key_to_remove): void {
                    try {
                        $removeRequiredKeys = function (string $key, $value) use ($key_to_remove): bool {
                            return $key === $key_to_remove;
                        };
                        new MonthOfAssignments(
                            (new \Ds\Map($this->valid_data))
                                ->filter($removeRequiredKeys)
                                ->toArray()
                        );
                    } catch (InvalidWeekOfAssignmentsArgumentException $e) {
                        $this->assertTrue(true);
                    }
                }
            );
    }

    public function testToArrayMethodReturnsExpectedValue()
    {
        $this->assertEquals(
            $this->valid_data,
            $this->MonthOfAssignments->toArray()
        );
    }
}
