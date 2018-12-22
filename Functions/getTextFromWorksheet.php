<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\ParserInterface;

function getTextFromWorksheet(ParserInterface $parser, string $file, int $page_number): string
{
    return $parser->parseFile($file)->getPages()[$page_number]->getText();
}
