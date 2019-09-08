<?php

namespace StudentAssignmentScheduler\Persistence;

use PHPUnit\Framework\TestCase;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;

class PersistenceTest extends TestCase
{
    protected function setup(): void
    {
        $test_basename = "test.json";
        $this->test_path = buildPath(__DIR__, "..", "..", "tmp");
        $this->year_dir = date_create()->format("Y");
        $this->destination = buildPath($this->test_path, $this->year_dir);
        $this->test_file = buildPath($this->destination, $test_basename);
        $this->test_registry = buildPath($this->test_path, sha1("test_registry") . ".php");
        $this->test_data = [
            "year" => $this->year_dir, // required
            "message" => "nothing to say"
        ];
    }

    protected function teardown(): void
    {
        file_exists($this->test_file) && unlink($this->test_file);
        file_exists($this->destination) && rmdir($this->destination);
        file_exists($this->test_registry) && unlink($this->test_registry);
    }

    public function testDataIsPersisted()
    {
        $this->assertFalse(
            \file_exists($this->test_file)
        );

        Functions\save(
            $this->test_data,
            $this->test_file,
            true, // test mode
            $this->test_registry
        );

        $this->assertTrue(
            \file_exists($this->test_file)
        );
    }
}
