<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;
use \Ds\Vector;
use StudentAssignmentScheduler\DocumentProduction\{
    PdfAssignmentFormWriter,
    PdfScheduleWriter
};
use function StudentAssignmentScheduler\DocumentProduction\Functions\writeAssignmentFormFromAssignment;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;
use function StudentAssignmentScheduler\Querying\Functions\weeksFrom;

class DocumentProductionTest extends TestCase
{
    protected function setup(): void
    {
        $this->mock_assignment_form_filename = "fake_assgn_form.pdf";
        $this->mock_schedule_basename = "fake_schedule";

        $this->path_to_created_assignment_form = buildPath(
            __DIR__,
            "..",
            "tmp",
            $this->mock_assignment_form_filename
        );

        $this->path_to_created_schedule = buildPath(
            __DIR__,
            "..",
            "tmp",
            $this->mock_schedule_basename . ".pdf"
        );

        $this->path_to_writer_config = buildPath(
            __DIR__,
            "..",
            "fake_config",
            "assignment_form_writer_config.php"
        );
    }

    public function testAssignmentFormIsCreated()
    {
        $Writer = new PdfAssignmentFormWriter(
            require $this->path_to_writer_config
        );

        $this->assertFalse(
            \file_exists($this->path_to_created_assignment_form)
        );

        writeAssignmentFormFromAssignment(
            $Writer,
            "5",
            [
                "date" => "01",
                "assignment" => "Talk",
                "name" => "John Wayne",
                "assistant" => "",
                "counsel_point" => ""
            ],
            $this->mock_assignment_form_filename
        );
        $this->assertFileExists($this->path_to_created_assignment_form);
    }

    public function testScheduleIsCreated()
    {
        $path_to_mock_month_of_assignments = buildPath(
            __DIR__,
            "..",
            "fake_data",
            "assignments"
        );

        $path_to_mock_schedule_for_january = buildPath(
            __DIR__,
            "..",
            "fake_data",
            "schedules",
            "January.json"
        );

        $month_of_assignments = (new Vector([
            "0110.json",
            "0117.json",
            "0124.json",
            "0131.json"
        ]))->map(
            function (string $basename) use ($path_to_mock_month_of_assignments): array {
                $filename = buildPath(
                    $path_to_mock_month_of_assignments,
                    $basename
                );
                $week_of_assignments = \json_decode(file_get_contents($filename), true);
                return weeksFrom($week_of_assignments);
            }
        )->toArray();


        $schedule_for_given_month = weeksFrom(json_decode(
            \file_get_contents($path_to_mock_schedule_for_january),
            true
        ));


        $path_to_schedule_writer_config = buildPath(
            __DIR__,
            "..",
            "fake_config",
            "schedule_writer_config.php"
        );

        $this->assertFalse(
            \file_exists(
                $this->path_to_created_schedule
            )
        );

        $ScheduleWriter = new PdfScheduleWriter(
            require $path_to_schedule_writer_config
        );


        $ScheduleWriter->create(
            $month_of_assignments,
            $schedule_for_given_month,
            $this->mock_schedule_basename
        );
        $this->assertFileExists($this->path_to_created_schedule);
    }

    protected function teardown(): void
    {
        @unlink($this->path_to_created_assignment_form);
        @unlink($this->path_to_created_schedule);
    }
}
