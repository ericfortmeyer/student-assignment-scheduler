<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

class ImportJsonTest extends TestCase
{
    protected function setup(): void
    {
        $this->destination = $this->test_path = __DIR__ . "/../data";
        $this->year = date_create()->format("Y");
        $this->test_basename = "test.json";
        $this->test_file = "{$this->test_path}/{$this->test_basename}";
        $this->test_registry = "{$this->test_path}/test_registry.php";
        $this->test_registry = $this->test_path . DIRECTORY_SEPARATOR . sha1("test_registry") . ".php";
        $this->test_info = [
            // required
            "year" => $this->year,
            "message" => "nothing to say"
        ];
    }

    protected function teardown(): void
    {
        file_exists($this->test_file) && unlink($this->test_file);
        file_exists($this->test_registry) && unlink($this->test_registry);
    }

    public function testImportsExpectedValue()
    {
        save(
            $this->test_info,
            $this->test_file,
            true,
            $this->test_registry
        );

        $this->assertSame(
            $this->test_info,
            importJson(
                $this->test_file,
                true,
                $this->test_registry
            )
        );
    }
}
