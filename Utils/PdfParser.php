<?php

namespace TalkSlipSender\Utils;

use Smalot\PdfParser\Parser;
use \Ds\Map;

use function TalkSlipSender\Functions\getAssignmentDate;
use function TalkSlipSender\Functions\getAssignment;

final class PdfParser implements ParserInterface
{
    /**
     * @var Parser|null
     */
    protected $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function parseFile(string $filename): DocumentWrapper
    {
        return new DocumentWrapper($this->parser->parseFile($filename));
    }

    public function getAssignments(string $textFromWorksheet, string $month, string $interval_spec): array
    {
        
        $parse_config = $this->getConfig();
        $pattern_func = $parse_config["pdf_assignment_pattern_func"];
        $assignment_date_pattern_func = $parse_config["assignment_date_pattern_func"];
    
        $map = new Map();
        $map->put(
            "date",
            getAssignmentDate(
                $assignment_date_pattern_func($month),
                $textFromWorksheet,
                $month,
                $interval_spec
            )
        );
        $map->put(5, getAssignment($pattern_func(5), $textFromWorksheet));
        $map->put(6, getAssignment($pattern_func(6), $textFromWorksheet));
        $map->put(7, getAssignment($pattern_func(7), $textFromWorksheet));

        return $map->toArray();
    }

    protected function getConfig(): array
    {
        return include "parse_config.php";
    }
}
