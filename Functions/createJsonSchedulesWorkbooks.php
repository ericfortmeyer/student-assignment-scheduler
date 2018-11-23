<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;

/**
 * Parse pdf schedules into json
 *
 * Data derived from the json schedules are used
 * when the user of the application schedules assignments
 * and for writing out assignment forms
 */
function createJsonSchedulesFromWorkbooks(
    Parser $parser,
    string $path_to_workbooks,
    string $data_destination
): array {
    return array_unique(
        array_map(
            function (string $workbook) use ($parser, $path_to_workbooks, $data_destination) {
                $year = getYearFromWorkbookPath($workbook);
                $month = getMonthFromWorkbookPath($workbook);
    
                $target_directory = "${data_destination}/${year}";
    
                !file_exists($target_directory) && mkdir($target_directory, 0777, true);
    
                !file_exists("${target_directory}/${month}.json")
                    && save(
                        extractDataFromPdf($parser, "$path_to_workbooks/$workbook"),
                        $data_destination,
                        $month
                    );
                return (int) $year;
            },
            array_diff(
                scandir($path_to_workbooks),
                [".", ".."]
            )
        )
    );
}
