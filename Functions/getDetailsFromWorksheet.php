<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\ParserInterface;

function getDetailsFromWorksheet(ParserInterface $parser, string $file): array
{
    return $parser
        ->parseFile($file)
        ->getDetails();
}
