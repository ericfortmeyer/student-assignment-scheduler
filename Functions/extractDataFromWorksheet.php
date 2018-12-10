<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\ParserInterface;
use TalkSlipSender\Utils\PdfParser;
use \Ds\Map;
use \Ds\Vector;

function extractDataFromWorksheet(ParserInterface $parser, string $file, string $interval_spec): array
{
    $title = getDetailsFromWorksheet($parser, $file)["Title"];
    $month = getMonthFromTitle($title);
    
    $page_numbers = new Vector(
        $parser instanceof PdfParser ? range(1, 6) : range(0, 4)
    );

    $getTextFromWorksheets = function (int $page) use ($parser, $file) {
        return getTextFromWorksheet($parser, $file, $page);
    };

    $onlyPagesWithSchedules = function ($text) {
        return strlen($text) > 400;
    };

    $assignmentsFromText = function (string $textFromWorksheet) use ($parser, $month, $interval_spec): array {
        return $parser->getAssignments($textFromWorksheet, $month, $interval_spec);
    };

    $textFromWorksheet = $page_numbers
        ->map($getTextFromWorksheets)
        ->filter($onlyPagesWithSchedules);

    $mapOfAssignments = new Map($textFromWorksheet->map($assignmentsFromText));

    $mapOfDateInfo = new Map();
    $mapOfDateInfo->put("month", $month);
    $mapOfDateInfo->put("year", getYearFromTitle($title));

    return $mapOfDateInfo->union($mapOfAssignments)->toArray();
}
