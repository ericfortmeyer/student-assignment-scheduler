<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

use function StudentAssignmentScheduler\Functions\Bootstrapping\buildPath;
use function StudentAssignmentScheduler\FileRegistry\Functions\generateRegistry;
use function StudentAssignmentScheduler\Functions\importJson;

use \DateTimeImmutable;

use StudentAssignmentScheduler\{
    Policies\JsonAssignmentFilenamePolicy,
    Destination,
    MonthOfAssignments,
    WeekOfAssignments,
    Date,
    Year,
    Month,
    DayOfMonth
};

class CopyAndSwapJsonAssignmentTest extends TestCase
{
    protected $test_registry = "";
    protected $path_to_mock_original_assignments = "";
    protected $expected_filename_of_copy = "";
    protected $path_to_copy = "";
    protected $contents_of_original_mock_assignments = "";

    protected function setup(): void
    {
        $path_to_mock_assignments = buildPath(__DIR__, "..", "..", "mocks");
        $this->test_registry = buildPath($path_to_mock_assignments, sha1("test") . ".php");
        $month = new Month("January");
        $day_of_month = new DayOfMonth($month, "31");
        $year = new Year(2019);

        $date = new Date(
            $month,
            $day_of_month,
            $year
        );

        $schedule_for_month = json_decode(
            file_get_contents(buildPath($path_to_mock_assignments, "months", "{$month->asText()}.json")),
            true
        );
        // create mock json assignment file
        $filename = Filenaming\jsonAssignmentFilename(
            new Destination($path_to_mock_assignments),
            $date,
            new JsonAssignmentFilenamePolicy(
                new MonthOfAssignments(
                    $schedule_for_month
                ),
                $date
            )
        );

        $this->path_to_mock_original_assignments = $filename;
        $original_file_basename = basename($this->path_to_mock_original_assignments);
        $date_time = new DateTimeImmutable();
        $this->expected_filename_of_copy = buildPath(
            $path_to_mock_assignments,
            $date_time->format(DateTimeImmutable::RFC3339) . "_" . $original_file_basename
        );

        $mock_original_weeks_of_assignments = $this->originalData();


        generateRegistry([], $this->test_registry);


        save(
            $mock_original_weeks_of_assignments,
            $filename,
            true,
            $this->test_registry
        );

        $this->contents_of_original_mock_assignments = \file_get_contents($this->path_to_mock_original_assignments);


        $this->path_to_copy = Filenaming\jsonAssignmentCopyFilename(
            new Destination($path_to_mock_assignments),
            $date_time,
            $original_file_basename
        );

        $key_of_original_assignment = 6;
        $original_assignment = $mock_original_weeks_of_assignments[$key_of_original_assignment];

        copyAndSwapJsonAssignment(
            $original_assignment,
            $this->newAssignment($key_of_original_assignment, $original_assignment),
            new WeekOfAssignments($month, $day_of_month, new \Ds\Map($mock_original_weeks_of_assignments)),
            new MonthOfAssignments($schedule_for_month),
            new Date(
                $month,
                dayOfMonthFromAssignmentDate($original_assignment["date"]),
                $year
            ),
            new Destination($path_to_mock_assignments),
            $date_time,
            true,
            $this->test_registry
        );
    }

    public function testCopiesOriginalAssignment()
    {
        $this->assertFileExists(
            $this->expected_filename_of_copy
        );

        $this->assertEquals(
            $this->expected_filename_of_copy,
            $this->path_to_copy
        );

        $this->assertStringEqualsFile($this->path_to_copy, $this->contents_of_original_mock_assignments);
    }
    
    public function testSwapsOriginalWithNewAssignment()
    {
        $expected = $this->modifiedData();

        $actual = importJson(
            $this->path_to_mock_original_assignments,
            true,
            $this->test_registry
        );

        $this->assertEquals($expected, $actual);
    }
    
    protected function teardown(): void
    {
        unlink($this->test_registry);
        unset($this->test_registry);
        
        unlink($this->path_to_mock_original_assignments);
        unlink($this->path_to_copy);
    }

    protected function newAssignment(
        int $key_of_original_assignment,
        array $original_assignment
    ): array {

        $newAssignmentInfo = [
            "name" => "Thelonius Monk",
            "assistant" => "Art Tatum"
        ];

        return [
            $key_of_original_assignment => array_replace(
                $original_assignment,
                $newAssignmentInfo
            )
        ];
    }

    protected function originalData(): array
    {
        return [
            "year" => "2019",
            4 => [
                "date" => "January 31",
                "assignment" => "Bible Reading",
                "name" => "Forrest Gump",
                "counsel point" => "",
                "assistant" => ""
            ],
            6 => [
                "date" => "January 31",
                "assignment" => "Second Return Visit",
                "name" => "Forrest Gump",
                "counsel point" => "",
                "assistant" => ""
            ],
            7 => [
                "date" => "January 31",
                "assignment" => "Bible Study",
                "name" => "Forrest Gump",
                "counsel point" => "",
                "assistant" => ""
            ]
        ];
    }

    protected function modifiedData(): array
    {
        return [
            4 => [
                "date" => "January 31",
                "assignment" => "Bible Reading",
                "name" => "Forrest Gump",
                "counsel point" => "",
                "assistant" => ""
            ],
            6 => [
                "date" => "January 31",
                "assignment" => "Second Return Visit",
                "name" => "Thelonius Monk",
                "counsel point" => "",
                "assistant" => "Art Tatum"
            ],
            7 => [
                "date" => "January 31",
                "assignment" => "Bible Study",
                "name" => "Forrest Gump",
                "counsel point" => "",
                "assistant" => ""
            ],
            "year" => "2019"
        ];
    }
}
