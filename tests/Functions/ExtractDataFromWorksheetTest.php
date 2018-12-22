<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;
use TalkSlipSender\Utils\PdfParser;
use TalkSlipSender\Utils\RtfParser;

class ExtractDataFromWorksheetTest extends TestCase
{
    protected function setup()
    {
        $this->config = include __DIR__ . "/../../config/config.php";
    }

    public function testReturnsExpectedDataWhenGivenPdfParser()
    {
        $year_month = "201812";
        $meeting_night = $this->config["meeting_night"];
        $interval_spec_for_meeting_night = $this->config["interval_spec"][$meeting_night];
        $PdfParser = new PdfParser(new Parser());

        $this->assertEquals(
            $this->getData($year_month),
            extractDataFromWorksheet(
                $PdfParser,
                $this->workbookFilename($year_month),
                $interval_spec_for_meeting_night
            )
        );
    }

    public function testReturnsExpectedDataWhenGivenRtfParser()
    {
        $year_month = "201901";
        $meeting_night = $this->config["meeting_night"];
        $interval_spec_for_meeting_night = $this->config["interval_spec"][$meeting_night];
        $RtfParser = new RtfParser();
        $this->assertEquals(
            $this->getData($year_month),
            extractDataFromWorksheet(
                $RtfParser,
                $this->workbookFilename($year_month, "rtf"),
                $interval_spec_for_meeting_night
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
