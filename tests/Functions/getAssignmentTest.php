<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;
use \Ds\Vector;
use \Ds\Map;

class GetAssignmentTest extends TestCase
{
    protected function setup()
    {
        $this->parser = new Parser();
    }

    public function testReturnsExpectedInfoFromDecember2018Workbook()
    {
        $this->doTest("201812");
    }

    private function doTest(string $year_month)
    {
        $expected = $this->getData($year_month);
        (new Map($this->pages($year_month)))->map(
            function (int $key, string $text) use ($expected) {
                (new Vector(range(5, 7)))->map(
                    function (int $assignment_num) use ($expected, $key, $text) {
                        $this->assertEquals(
                            $expected[$key][$assignment_num],
                            getAssignment($assignment_num, $text)
                        );
                    }
                );
            }
        );
    }

    private function pages(string $year_month): array
    {
        return (new Vector(range(1, 6)))
            ->map(function (int $page_num) use ($year_month) {
                return $this->getText($year_month, $page_num);
            })
            ->filter(function (string $text) {
                return $this->hasSchedule($text);
            })
            ->toArray();
    }

    private function hasSchedule(string $text): bool
    {
        return strlen($text) > 400;
    }

    protected function getData(string $year_month)
    {
        return require __DIR__ . "/../data/${year_month}.php";
    }

    protected function getText(string $year_month, int $page)
    {
        return getTextFromPdf(
            $this->parser,
            __DIR__ . "/../mocks/mwb_ASL_${year_month}.pdf",
            $page
        );
    }
}
