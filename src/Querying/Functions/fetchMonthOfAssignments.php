<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\MonthOfAssignments;
use StudentAssignmentScheduler\Month;
use StudentAssignmentScheduler\Year;
use StudentAssignmentScheduler\Downloading\MWBDownloader\Config\DownloadConfig;
use StudentAssignmentScheduler\Parsing\RtfParser;
use StudentAssignmentScheduler\Downloading\MWBDownloader\Utils\PageNotFoundException;
use StudentAssignmentScheduler\Downloading\MWBDownloader\Month as MonthObj;
use function StudentAssignmentScheduler\Parsing\Functions\createJsonSchedulesFromWorkbooks;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;
use function StudentAssignmentScheduler\Utils\Functions\getConfig;
use function StudentAssignmentScheduler\Downloading\Functions\download;

/**
 * Return a representation of the information
 * needed to make assignments for a given
 * month.
 *
 * @param Month $month
 * @param Year $year
 * @return MonthOfAssignments Information required to make assignments for a given month
 */
function fetchMonthOfAssignments(Month $month, Year $year): MonthOfAssignments
{
    $path_config = require buildPath(
        dirname(dirname(dirname(__DIR__))),
        "config",
        "path_config.php"
    );
    $path_to_schedules = buildPath(
        $path_config["path_to_data"],
        (string) $year
    );
    $filename_of_schedule = buildPath($path_to_schedules, $month->asText() . ".json");
    downloadIfNotExists($filename_of_schedule, $month, $path_config);
    $constructorArgsForEmptyInstance = ["month" => (string) $month, "year" => (string) $year];

    return new MonthOfAssignments(
        file_exists($filename_of_schedule)
            ? importJson($filename_of_schedule)
            : $constructorArgsForEmptyInstance
    );
}

function downloadIfNotExists(string $filename_of_schedule, Month $month, array $path_config): void
{
    try {
        if (!file_exists($filename_of_schedule)) {
            $config = getConfig();
            $workbook_format = $config["workbook_format"];
            $path_to_workbooks = buildPath($path_config["path_to_workbooks"], $workbook_format);
            $parser = $config["workbook_parser_implementations"][$workbook_format];
            download(new MonthObj((string)$month), new DownloadConfig($config));
            createJsonSchedulesFromWorkbooks(
                new $parser($config["meeting_night"]),
                $path_to_workbooks,
                $path_config["path_to_data"],
                function () {
                }
            );
        }
    } catch (PageNotFoundException $e) {
        return;
    }
}
