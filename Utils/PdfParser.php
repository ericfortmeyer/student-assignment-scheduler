<?php

namespace TalkSlipSender\Utils;

use Smalot\PdfParser\Parser;
use \Ds\Map;
use \Ds\Vector;

use function TalkSlipSender\Functions\getAssignmentDate;
use function TalkSlipSender\Functions\getAssignment;

final class PdfParser implements ParserInterface
{
    /**
     * @var Parser|null
     */
    protected $parser;

    /**
     * @var string
     */
    protected $meeting_night = "";

    public function __construct(Parser $parser, string $meeting_night)
    {
        $this->parser = $parser;
        $this->meeting_night = $meeting_night;
    }

    public function parseFile(string $filename): DocumentWrapper
    {
        return new DocumentWrapper($this->parser->parseFile($filename));
    }

    public function getAssignments(string $textFromWorksheet, string $month): array
    {
        
        $parse_config = $this->getConfig();
        $pattern_func = $parse_config["pdf_assignment_pattern_func"];
        $assignment_date_pattern_func = $parse_config["assignment_date_pattern_func"];
        $interval_spec = $parse_config["interval_spec"][$this->meeting_night];
    
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

    public function pageNumbers(string $filename = ""): Vector
    {
        return new Vector(range(1, 6));
    }

    protected function getConfig(): array
    {
        return include "parse_config.php";
    }
}
