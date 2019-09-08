<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

use PHPUnit\Framework\TestCase;
use StudentAssignmentScheduler\Parsing\RtfParser;
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;

class CreateJsonSchedulesFromWorkbooksTest extends TestCase
{
    protected function setup(): void
    {
        // setup function's dependencies
        $this->meeting_night = "Thursday";
        $this->data_destination = buildPath(__DIR__, "..", "..", "..", "tmp");
        $this->created_file = buildPath($this->data_destination, "2019", "January.json");
    }

    protected function teardown(): void
    {
        unlink($this->created_file);
        rmdir(
            buildPath($this->data_destination, "2019")
        );
    }

    public function testJsonScheduleCreatedFromParsingWorkbook()
    {
        $parser = new RtfParser($this->meeting_night);
        $path_to_workbooks = buildPath(__DIR__, "..", "..", "..", "fake_data", "workbooks", "rtf");
        $scheduleCreationNotification = function () {
            // noop
        };

        createJsonSchedulesFromWorkbooks(
            $parser,
            $path_to_workbooks,
            $this->data_destination,
            $scheduleCreationNotification
        );

        $this->assertFileExists(
            $this->created_file
        );
    }
}
