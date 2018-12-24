<?php

namespace TalkSlipSender\Utils;

use PHPUnit\Framework\TestCase;

use \Ds\Vector;

use function TalkSlipSender\Functions\weeksFrom;
use function TalkSlipSender\Functions\importJson;
use function TalkSlipSender\Functions\importAssignments;
use function TalkSlipSender\FileRegistry\Functions\registerFile;

class ScheduleWriterTest extends TestCase
{
    /**
     * @var array $config
     */
    protected $config = [];

    /**
     * @var string $test_schedule_basename
     */
    protected $test_schedule_basename = "";

    /**
     * @var string $path_to_mock_schedules
     */
    protected $path_to_mock_schedules = "";

    /**
     * @var string $path_to_mock_assignments
     */
    protected $path_to_mock_assignments = "";

    /**
     * @var string $mock_registry
     */
    protected $mock_registry;

    /**
     * @var string $test_schedule_filename
     */
    protected $test_schedule_filename;

    protected function setup()
    {
        $schedules_destination = realpath(__DIR__ . "/../tmp");
        $this->config = require realpath(__DIR__ . "/../../config/config.php");
        $this->path_to_mock_schedules = realpath(__DIR__ . "/../mocks/months");
        $this->path_to_mock_assignments = realpath(__DIR__ . "/../mocks");
        $this->mock_registry = __DIR__ . "/../tmp/registry.php";
        $this->config["schedules_destination"] = $schedules_destination;
        $this->test_schedule_basename = "come_on_now";
        $this->registerMockFiles();
    }

    protected function registerMockFiles()
    {
        $register_mocks = function (string $directory) {
            $register = function (string $filename) use ($directory) {
                $file = "${directory}/${filename}";
                registerFile(\sha1_file($file), $file, $this->mock_registry);
            };
            $mocks = new Vector(array_diff(scandir($directory), [".", ".."]));

            $mocks->map($register);
        };

        $register_mocks($this->path_to_mock_assignments);
        $register_mocks($this->path_to_mock_schedules);
    }

    protected function teardown()
    {
        file_exists($this->test_schedule_filename) && unlink($this->test_schedule_filename);
    }

    public function testPdfWriterImplementationExists()
    {
        $implementation = new PdfScheduleWriter($this->config);
        $this->assertInstanceOf(
            PdfScheduleWriter::class,
            $implementation
        );
    }

    public function testPdfWriterCreatesSchedule()
    {
        $writer = new PdfScheduleWriter($this->config);
        $expected_file = $this->test_schedule_filename = "{$this->config["schedules_destination"]}/{$this->test_schedule_basename}.pdf";
        $month = "January";


        $writer->create(
            $this->importAssignments($month, $this->path_to_mock_assignments),
            $this->schedule($month),
            $this->test_schedule_basename
        );

        $this->assertFileExists($expected_file);
    }

    protected function importAssignments(string $month, string $path_to_json_assignments): array
    {
        return importAssignments($month, $path_to_json_assignments, $this->importFunc());
    }

    protected function importFunc(): \Closure
    {
        return function (string $path_to_json_assignments): \Closure {
            return function (string $json_file) use ($path_to_json_assignments): array {
                return importJson("${path_to_json_assignments}/${json_file}", true, $this->mock_registry);
            };
        };    
    }

    protected function schedule(string $month): array
    {
        $filename = "{$this->path_to_mock_schedules}/${month}.json";

        return weeksFrom(importJson($filename, true, $this->mock_registry));
    }
}
