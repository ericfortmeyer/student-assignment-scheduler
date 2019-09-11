<?php

namespace StudentAssignmentScheduler\Utils\Functions;

use PHPUnit\Framework\TestCase;

class MonthsFromScheduleFilenamesTest extends TestCase
{
    public function testReturnsExpectedArrayOfMonthsAsText()
    {
        $path_to_json_schedules = __DIR__ . "/../../tmp";
        $fake_json_schedules_filenames = [
            "January.json",
            "March.json"
        ];
        $expected_array_of_months_result = [
            ["month" => "January"],
            ["month" => "March"]
        ];
        $this->makeFakeSchedules($fake_json_schedules_filenames, $path_to_json_schedules);
        $this->assertSame(
            $expected_array_of_months_result,
            monthsFromScheduleFilenames($path_to_json_schedules, 2018, true)
        );
        $this->removeFakeSchedules($fake_json_schedules_filenames, $path_to_json_schedules);
    }

    private function makeFakeSchedules(array $filenames, string $path_to_json_schedules)
    {
        $makeFile = function (string $filename) use ($path_to_json_schedules) {
            $fullpath = "${path_to_json_schedules}/${filename}";
            touch($fullpath);
        };
        array_map($makeFile, $filenames);
    }

    private function removeFakeSchedules(array $filenames, string $path_to_json_schedules)
    {
        $removeFile = function (string $filename) use ($path_to_json_schedules) {
            $fullpath = "${path_to_json_schedules}/${filename}";
            unlink($fullpath);
        };
        array_map($removeFile, $filenames);
    }

    public function testReturnsEmptyArrayIfWhenFilenamesHaveMonthsInThePastAndDoPastMonthsFlagIsSetToFalse()
    {
        // the default setting for doPastMonths is false
        $path_to_json_schedules = __DIR__ . "/../../tmp";
        $fake_json_schedules_filenames = [
            "January.json",
            "March.json"
        ];
        $expected_array_of_months_result = [];
        $this->makeFakeSchedules($fake_json_schedules_filenames, $path_to_json_schedules);
        $this->assertSame(
            $expected_array_of_months_result,
            monthsFromScheduleFilenames($path_to_json_schedules, null, false)
        );
        $this->removeFakeSchedules($fake_json_schedules_filenames, $path_to_json_schedules);
    }
}
