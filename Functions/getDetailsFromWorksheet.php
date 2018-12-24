<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\ParserInterface;

function getDetailsFromWorksheet(ParserInterface $parser, string $file): array
{
    return $parser
        ->parseFile($file)
        ->getDetails();
}
