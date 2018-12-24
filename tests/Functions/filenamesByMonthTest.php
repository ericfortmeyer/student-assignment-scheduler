<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

class FilenamesByMonthTest extends TestCase
{
    protected function setup()
    {
        $this->expected_files = [
            "0110.json",
            "0117.json",
            "0124.json",
            "0131.json"
        ];
    }
    public function testReturnsExpectedFiles()
    {
        $month = "January";
        $path_to_files = __DIR__ . "/../mocks/";
        $this->assertEquals(
            $this->expected_files,
            array_values(filenamesByMonth($month, $path_to_files))
        );
    }
}
