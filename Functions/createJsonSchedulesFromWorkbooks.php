<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\ParserInterface as Parser;
use \Ds\Set;
use \Ds\Vector;

define("WORKBOOKS_NOT_DOWNLOADED_ERROR_MSG", "It looks like the workbooks haven't been set up yet." . PHP_EOL
    . "Make sure that the workbooks of {$parser->getFileType()} are"
    . " located in ${path_to_workbooks}"
);

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
            WORKBOOKS_NOT_DOWNLOADED_ERROR_MSG,
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
            $filename = "${data_destination}/${year}/${month}.json";
            $workbook = "${path_to_workbooks}/${workbook}";
            
            if (!file_exists($filename)) {
                $data = extractDataFromWorkbook($parser, $workbook);
                save($data, $filename, true);
                $scheduleCreationNotificationFunc($month);
            }

            return (int) $year;
        }
    ));
}
