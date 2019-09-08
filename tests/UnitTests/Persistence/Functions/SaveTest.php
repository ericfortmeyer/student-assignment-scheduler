<?php

namespace StudentAssignmentScheduler\Persistence\Functions;

use PHPUnit\Framework\TestCase;

class SaveTest extends TestCase
{
    protected function setup(): void
    {
        $this->test_path = __DIR__ . "/../../../tmp";
        $this->year_dir = date_create()->format("Y");
        $this->destination = "{$this->test_path}/{$this->year_dir}";
        $this->test_basename = "test.json";
        $this->test_file = "{$this->destination}/{$this->test_basename}";
        $this->test_registry = $this->test_path . DIRECTORY_SEPARATOR . sha1("test_registry") . ".php";
        $this->test_info = [
            // required
            "year" => $this->year_dir,
            "message" => "nothing to say"
        ];
    }

    protected function teardown(): void
    {
        file_exists($this->test_file) && unlink($this->test_file);
        file_exists($this->destination) && rmdir($this->destination);
        file_exists($this->test_registry) && unlink($this->test_registry);
    }

    protected function callTestFunction()
    {
        save(
            $this->test_info,
            $this->test_file,
            true,
            $this->test_registry
        );
    }

    public function testSavesFile()
    {
        $this->callTestFunction();

        $this->assertFileExists($this->test_file);
    }

    public function testRegistersFile()
    {
        $this->callTestFunction();
        $registry = include $this->test_registry;
        $test_file = $this->test_file;
        $hash = sha1_file($test_file);

        $this->assertArrayHasKey(
            $hash,
            $registry
        );

        $this->assertSame(
            $test_file,
            $registry[$hash]
        );

        $this->assertSame(
            $hash,
            sha1_file($test_file)
        );
    }
}
