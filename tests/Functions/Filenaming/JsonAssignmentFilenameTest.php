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
    DayOfMonth
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

    protected function setup()
    {
        $context = new Context([1]);
    }

    public function testTrue()
    {
        $this->assertTrue(
            true
        );
    }

    public function testReturnsExpectedFilenameWhenWeekOverlaps()
    {
        $month_string = "April";
        $day_of_month_string = "02";

        $Month = new Month($month_string);
        $DayOfMonth = new DayOfMonth($day_of_month_string);

        // only what's needed to test
        $schedule_for_month = [
            "month" => $month_string,
            [ "date" => "04" ],
            [ "date" => "11" ],
            [ "date" => "25" ],
            [ "date" => "02" ],
        ];

        $expected = __DIR__ . "/04_0502.json";
        $actual = jsonAssignmentFilename(
            new Destination(__DIR__),
            $Month,
            $DayOfMonth,
            new JsonAssignmentFilenamePolicy(
                new Context([
                    JsonAssignmentFilenamePolicy::SCHEDULE_FOR_MONTH => $schedule_for_month,
                    JsonAssignmentFilenamePolicy::MONTH => $Month,
                    JsonAssignmentFilenamePolicy::DAY_OF_MONTH => $DayOfMonth
                ])
            )
        );

        $this->assertSame($actual, $expected);
    }

    public function testDoesNotAddToMonthWhenWeekDoesNotOverlapMonths()
    {
        $month_string = "April";
        $day_of_month_string = "04";

        $Month = new Month($month_string);
        $DayOfMonth = new DayOfMonth($day_of_month_string);

        // only what's needed to test
        $schedule_for_month = [
            "month" => $month_string,
            [ "date" => "04" ],
            [ "date" => "11" ],
            [ "date" => "25" ],
            [ "date" => "02" ],
        ];

        $expected = __DIR__  . "/04_0404.json";

        $actual = jsonAssignmentFilename(
            new Destination(__DIR__),
            $Month,
            $DayOfMonth,
            new JsonAssignmentFilenamePolicy(
                new Context([
                    JsonAssignmentFilenamePolicy::SCHEDULE_FOR_MONTH => $schedule_for_month,
                    JsonAssignmentFilenamePolicy::MONTH => $Month,
                    JsonAssignmentFilenamePolicy::DAY_OF_MONTH => $DayOfMonth
                ])
            )
        );

        $this->assertSame($expected, $actual);
    }
}
