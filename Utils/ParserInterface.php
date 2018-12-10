<?php

namespace TalkSlipSender\Utils;

interface ParserInterface
{
    public function parseFile(string $filename): DocumentWrapper;
    public function getAssignments(string $textFromWorksheet, string $month, string $interval_spec): array;
}
