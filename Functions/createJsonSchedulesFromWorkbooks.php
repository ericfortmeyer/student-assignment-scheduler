<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;
use \Ds\Set;
use \Ds\Vector;

use function TalkSlipSender\Functions\CLI\green;

/**
 * Parse pdf schedules into json
 *
 * Data derived from the json schedules are used
 * when the user of the application schedules assignments
 * and for writing out assignment forms
 *
 * Returns an array of years
 */
function createJsonSchedulesFromWorkbooks(
    Parser $parser,
    string $path_to_workbooks,
    string $data_destination,
    string $interval_spec_for_meeting_night
): Set {
    
    // Use set so the values will be unique
    return (new Set((new Vector(filenamesInDirectory($path_to_workbooks)))->map(
        function (string $workbook) use ($parser, $path_to_workbooks, $data_destination, $interval_spec_for_meeting_night) {
            $year = getYearFromWorkbookPath($workbook);
            $month = getMonthFromWorkbookPath($workbook);
            $filename = "${data_destination}/${year}/${month}.json";
            
            if (!file_exists($filename)) {
                $data = extractDataFromPdf($parser, "${path_to_workbooks}/${workbook}", $interval_spec_for_meeting_night);
                save($data, $filename, true);
                print green("Schedule for $month was created");
            }

            return (int) $year;
        }
    )));
}
