<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;

class filenamesByMonthTest extends TestCase
{
    protected function setup()
    {
        $this->expected_files = [
            "1108.json",
            "1115.json",
            "1122.json",
            "1129.json"
        ];
    }
    public function testReturnsExpectedFiles()
    {
        $month = "November";
        $path_to_files = __DIR__ . "/../mocks/";
        $this->assertEquals(
            $this->expected_files,
            array_values(filenamesByMonth($month, $path_to_files))
        );
    }
}
