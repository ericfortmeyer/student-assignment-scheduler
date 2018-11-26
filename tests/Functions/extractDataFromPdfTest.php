<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;

class ExtractDataFromPdfTest extends TestCase
{
    protected function setup()
    {
        $this->parser = new Parser();
    }

    public function testReturnsExpectedData()
    {
        $year_month = "201812";
        $this->assertEquals(
            $this->getData($year_month),
            extractDataFromPdf(
                $this->parser,
                $this->workbookFilename($year_month)
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
