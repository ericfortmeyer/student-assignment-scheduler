<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

use StudentAssignmentScheduler\Parsing\ParserInterface;

function getDetailsFromWorksheet(ParserInterface $parser, string $file): array
{
    return $parser
        ->parseFile($file)
        ->getDetails();
}
