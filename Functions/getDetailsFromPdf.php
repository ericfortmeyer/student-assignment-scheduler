<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;

function getDetailsFromPdf(Parser $parser, string $file): array
{
    return $parser
        ->parseFile($file)
        ->getDetails();
}
