<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;
use \Ds\Set;
use \Ds\Vector;

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
    string $data_destination
): Set {
    
    // Use set so the values will be unique
    return (new Set((new Vector(filenamesInDirectory($path_to_workbooks)))->map(
        function (string $workbook) use ($parser, $path_to_workbooks, $data_destination) {
            $year = getYearFromWorkbookPath($workbook);
            $month = getMonthFromWorkbookPath($workbook);

            $data = extractDataFromPdf($parser, "${path_to_workbooks}/${workbook}");
            $filename = "${data_destination}/${year}/${month}.json";

            save($data, $filename);

            return (int) $year;
        }
    )));
}
