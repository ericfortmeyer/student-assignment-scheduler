<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

use StudentAssignmentScheduler\Parsing\ParserInterface as Parser;
use \Ds\{
    Set,
    Vector
};
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\Persistence\Functions\save;
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;
/**
 * Parse workbooks into json for use later in the application.
 *
 * Data derived from the json schedules are used
 * when the user of the application schedules assignments
 * and for writing out assignment forms.
 *
 * Returns an array of years since the last week of the December schedule
 * may be in January of the following year.
 *
 * @param Parser $parser Capable of obtaining data from worksheet files.
 * @param string $path_to_workbooks
 * @param string $data_destination
 * @return Set The year(s) of the json schedules created.
 *   Required since December may have more than one year in it's schedule.
 */
function createJsonSchedulesFromWorkbooks(
    Parser $parser,
    string $path_to_workbooks,
    string $data_destination,
    \Closure $scheduleCreationNotificationFunc
): Set {

    $VectorOfWorkbooks = new Vector(
        filenamesInDirectory(
            $path_to_workbooks,
            $parser->getErrorMsg($path_to_workbooks),
            true
        )
    );
    
    // Use set so that there will not be duplicate years returned
    return new Set($VectorOfWorkbooks->map(
        function (string $workbook) use (
            $parser,
            $path_to_workbooks,
            $data_destination,
            $scheduleCreationNotificationFunc
        ) {
            $year = getYearFromWorkbookPath($workbook);
            $month = getMonthFromWorkbookPath($workbook);
            
            $yearDir = buildPath($data_destination, $year);
            $filename = buildPath($yearDir, "${month}.json");
            $workbook = buildPath($path_to_workbooks, $workbook);
            
            if (!file_exists($filename)) {
                $data = extractDataFromWorkbook($parser, $workbook);
                save($data, $filename, true);
                $scheduleCreationNotificationFunc($month);
            }

            return (int) $year;
        }
    ));
}
