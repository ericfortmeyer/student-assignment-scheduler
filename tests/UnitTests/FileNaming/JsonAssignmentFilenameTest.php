<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Policies\{
    Context,
    JsonAssignmentFilenamePolicy
};

use StudentAssignmentScheduler\{
    Destination,
    Month,
    DayOfMonth,
    Date,
    Year,
    MonthOfAssignments
};

class JsonAssignmentFilenameTest extends TestCase
{
    public function testReturnsExpectedFilenameWhenWeekOverlaps()
    {
        $month_string = "April";
        $day_of_month_string = "02";

        $Month = new Month($month_string);
        $DayOfMonth = new DayOfMonth($Month, $day_of_month_string);
        $Year = new Year(2058);

        $date = new Date(
            $Month,
            $DayOfMonth,
            $Year
        );

        // only what's needed to test
        $schedule_for_month = [
            "year" => (string) $Year,
            "month" => $month_string,
            [ "date" => "04" ],
            [ "date" => "11" ],
            [ "date" => "25" ],
            [ "date" => "02" ],
        ];

        $expected = __DIR__ . "/04_0502.json";
        $actual = jsonAssignmentFilename(
            new Destination(__DIR__),
            $date,
            new JsonAssignmentFilenamePolicy(
                new MonthOfAssignments(
                    $schedule_for_month
                ),
                $date
            )
        );

        $this->assertSame($expected, $actual);
    }

    public function testDoesNotAddToMonthWhenWeekDoesNotOverlapMonths()
    {
        $month_string = "April";
        $day_of_month_string = "04";
        $year_as_int = 2058;


        $Month = new Month($month_string);
        $DayOfMonth = new DayOfMonth($Month, $day_of_month_string);
        $Year = new Year($year_as_int);

        $date = new Date(
            $Month,
            $DayOfMonth,
            $Year
        );



        // only what's needed to test
        $schedule_for_month = [
            "year" => $year_as_int,
            "month" => $month_string,
            [ "date" => "04" ],
            [ "date" => "11" ],
            [ "date" => "25" ],
            [ "date" => "02" ],
        ];

        $expected = __DIR__  . "/04_0404.json";

        $actual = jsonAssignmentFilename(
            new Destination(__DIR__),
            $date,
            new JsonAssignmentFilenamePolicy(
                new MonthOfAssignments(
                    $schedule_for_month
                ),
                $date
            )
        );

        $this->assertSame($expected, $actual);
    }
}
