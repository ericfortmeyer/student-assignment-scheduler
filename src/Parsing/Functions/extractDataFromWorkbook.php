<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

use StudentAssignmentScheduler\Parsing\ParserInterface;
use \Ds\Map;

/**
 * Use parser to extract an array of data from the worksheet
 *
 * @param ParserInterface $parser
 * @param string $filename
 * @return array
 */
function extractDataFromWorkbook(ParserInterface $parser, string $filename): array
{
    // mnemonic title of the worksheet found in it's text
    $title = getDetailsFromWorksheet($parser, $filename)["Title"];

    $year = getYearFromTitle($title);
    $month = getMonthFromTitle($title);

    $getTextFromWorksheets = function (int $page_number) use ($parser, $filename) {
        return $parser->parseFile($filename)->getPages()[$page_number]->getText();
    };

    $getAssignmentsFromText = function (string $textFromWorksheet) use ($parser, $month): array {
        return $parser->getAssignments($textFromWorksheet, $month);
    };

    $VectorOfPageNumbers = $parser->pageNumbers($filename);

    $VectorOfTextFromWorksheet = $VectorOfPageNumbers->map($getTextFromWorksheets);

    $MapOfAssignments = new Map($VectorOfTextFromWorksheet->map($getAssignmentsFromText));

    $MapOfDateInfo = new Map(["month" => $month, "year" => $year]);

    return $MapOfDateInfo->union($MapOfAssignments)->toArray();
}
