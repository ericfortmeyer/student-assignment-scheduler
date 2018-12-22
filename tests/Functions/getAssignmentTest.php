<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Parser;
use TalkSlipSender\Utils\PdfParser;
use \Ds\Vector;
use \Ds\Map;

class GetAssignmentTest extends TestCase
{
    protected function setup()
    {
        $this->parser = new PdfParser(new Parser());
    }

    public function testReturnsExpectedInfoFromDecember2018Workbook()
    {
        $this->doTest("201812");
    }

    private function doTest(string $year_month)
    {
        $expected = $this->getData($year_month);
        $pattern_func = $this->getConfig()["pdf_assignment_pattern_func"];
        (new Map($this->pages($year_month)))->map(
            function (int $key, string $text) use ($expected, $pattern_func) {
                (new Vector(range(5, 7)))->map(
                    function (int $assignment_num) use ($expected, $key, $text, $pattern_func) {
                        $pattern = $pattern_func($assignment_num);
                        $this->assertEquals(
                            $expected[$key][$assignment_num],
                            getAssignment($pattern, $text)
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

    protected function getConfig(): array
    {
        return require __DIR__ . "/../../Utils/parse_config.php";
    }

    protected function getData(string $year_month)
    {
        return require __DIR__ . "/../data/${year_month}.php";
    }

    protected function getText(string $year_month, int $page)
    {
        return getTextFromWorksheet(
            $this->parser,
            __DIR__ . "/../mocks/mwb_ASL_${year_month}.pdf",
            $page
        );
    }
}
