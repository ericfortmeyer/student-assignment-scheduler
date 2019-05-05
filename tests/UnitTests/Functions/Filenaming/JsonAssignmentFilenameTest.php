<?php

namespace StudentAssignmentScheduler\Functions\Filenaming;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Rules\{
    Context,
    JsonAssignmentFilenamePolicy
};

use StudentAssignmentScheduler\Classes\{
    Destination,
    Month,
    DayOfMonth,
    Date,
    Year,
    MonthOfAssignments
};

class JsonAssignmentFilenameTest extends TestCase
{
    /*
        The function receives as input:
        (1) destination of assignments
        (2) Two digit month of the assignments' schedule
        (3) The date of the week for the assignment
        (4) Policy for determing the actual month of a week
            since it may overlap two months.

        The function should output:
        directory + 2 digit month + underscore
        + week's actual month + day of the month + file extension

        In the case of May 2, 2019 (which is included in April's schdule)
        we should get "04_0502.json"

        Naming the files containing the weeks of assignments in this way
        simplifies file storage, retrieving the files, and the application's
        use of the filename for information about the week of assignments.
    */

    public function testReturnsExpectedFilenameWhenWeekOverlaps()
    {
        $month_string = "April";
        $day_of_month_string = "02";

        $Month = new Month($month_string);
        $DayOfMonth = new DayOfMonth($Month, "02");
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

        $this->assertSame($actual, $expected);
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
