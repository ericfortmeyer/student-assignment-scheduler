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
        $map = new Map();
        $map->put("date", getAssignmentDate($textFromWorksheet, $month, $interval_spec));
        $map->put(5, getAssignment(5, $textFromWorksheet));
        $map->put(6, getAssignment(6, $textFromWorksheet));
        $map->put(7, getAssignment(7, $textFromWorksheet));

        return $map->toArray();
    }
}
