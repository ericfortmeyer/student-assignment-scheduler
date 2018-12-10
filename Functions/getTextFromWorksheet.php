<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\ParserInterface;

function getTextFromWorksheet(ParserInterface $parser, string $file, int $page_number): string
{
    //if the length is less than 400, the text is not needed
    return (strlen($text = $parser
            ->parseFile($file)
            ->getPages()[$page_number]
            ->getText()) > 400
        ) ? $text : "";
}
