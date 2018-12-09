<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;

class ExtractDataFromPdfTest extends TestCase
{
    protected function setup()
    {
        $this->parser = new Parser();
        $this->config = include __DIR__ . "/../../config/config.php";
    }

    public function testReturnsExpectedData()
    {
        $year_month = "201812";
        $meeting_night = $this->config["meeting_night"];
        $interval_spec_for_meeting_night = $this->config["interval_spec"][$meeting_night];
        $this->assertEquals(
            $this->getData($year_month),
            extractDataFromPdf(
                $this->parser,
                $this->workbookFilename($year_month),
                $interval_spec_for_meeting_night
            )
        );
    }

    protected function workbookFilename(string $year_month)
    {
        return __DIR__ . "/../mocks/mwb_ASL_${year_month}.pdf";
    }

    protected function getData(string $year_month)
    {
        return require __DIR__ . "/../data/${year_month}.php";
    }
}
