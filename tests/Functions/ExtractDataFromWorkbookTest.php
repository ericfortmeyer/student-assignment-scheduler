<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;
use StudentAssignmentScheduler\Utils\PdfParser;
use StudentAssignmentScheduler\Utils\RtfParser;

class extractDataFromWorkbookTest extends TestCase
{
    protected function setup()
    {
        $this->config = include realpath(__DIR__ . "/../../config/config.php");
    }

    public function testReturnsExpectedDataWhenGivenRtfParser()
    {
        $year_month = "201901";
        $meeting_night = $this->config["meeting_night"];
        $RtfParser = new RtfParser($meeting_night);
        $this->assertEquals(
            $this->getData($year_month),
            extractDataFromWorkbook(
                $RtfParser,
                $this->workbookFilename($year_month, "rtf")
            )
        );
    }

    protected function workbookFilename(string $year_month, string $ext = "pdf")
    {
        return realpath(__DIR__ . "/../mocks/mwb_ASL_${year_month}.${ext}");
    }

    protected function getData(string $year_month)
    {
        return require realpath(__DIR__ . "/../data/${year_month}.php");
    }
}
