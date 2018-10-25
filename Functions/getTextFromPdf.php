<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;

function getTextFromPdf(Parser $parser, string $file, int $page_number): string
{
    return $parser
        ->parseFile($file)
        ->getPages()[$page_number]
        ->getText();
}
