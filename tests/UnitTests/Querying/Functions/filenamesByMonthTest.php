<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use PHPUnit\Framework\TestCase;

class FilenamesByMonthTest extends TestCase
{
    protected function setup(): void
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
        $path_to_files = __DIR__ . "/../../../fake_data/assignments/";
        $this->assertEquals(
            $this->expected_files,
            array_values(filenamesByMonth($month, $path_to_files))
        );
    }
}
