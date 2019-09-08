<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

use StudentAssignmentScheduler\Parsing\ParserInterface;

/**
 * @codeCoverageIgnore
 */
function workbookParserImplementation(array $config): ParserInterface
{
    if (!key_exists("meeting_night", $config)) {
        $no_meeting_night_msg = "The meeting night must be setup in the config file "
            . "with 'meeting_night' as it's key";
        throw new \InvalidArgumentException($no_meeting_night_msg);
    }

    if (!key_exists("workbook_format", $config)) {
        $no_workbook_format_msg = "It looks like you haven't chosen which file format"
            . " the workbook is in. The workbook parser implementation must be set in the config file"
            . " with 'workbook_parser' as it's key."
            . "  Use the fully qualified class name";
        throw new \InvalidArgumentException($no_workbook_format_msg);
    }

    $workbook_format = $config["workbook_format"];
    $meeting_night = $config["meeting_night"];
    $ClassnameOfImplementation = $config["workbook_parser_implementations"][$workbook_format];

    if (!class_exists($ClassnameOfImplementation)) {
        $workbook_parser_error_msg = "An error occured when trying " . PHP_EOL
            . " locate the part of the program responsibile for parsing the workbook." . PHP_EOL
            . " Check the 'workbook_parser' entry in the config file to make sure it is correct." . PHP_EOL
            . " $ClassnameOfImplementation does not exist" . PHP_EOL . PHP_EOL;
        throw new \Exception($workbook_parser_error_msg);
    }

    return new $ClassnameOfImplementation($meeting_night);
}
