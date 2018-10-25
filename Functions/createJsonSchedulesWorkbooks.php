<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;

function createJsonSchedulesFromWorkbooks(
    Parser $parser,
    string $path_to_workbooks,
    string $data_destination
) {
    array_map(
        function (string $workbook) use ($parser, $path_to_workbooks, $data_destination) {
            $year = getYearFromWorkbookPath($workbook);
            $month = getMonthFromWorkbookPath($workbook);

            !file_exists("$data_destination/$year/$month.json")
                && save(
                    extractDataFromPdf($parser, "$path_to_workbooks/$workbook"),
                    $data_destination,
                    $month
                );
        },
        array_diff(
            scandir($path_to_workbooks),
            [".", ".."]
        )
    );
}
