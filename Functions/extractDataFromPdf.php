<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;

function extractDataFromPdf(Parser $parser, string $file): array
{
    $title = getDetailsFromPdf($parser, $file)["Title"];

    return array_merge(
        [
            "month" => $month = getMonthFromTitle($title),
            "year" => getYearFromTitle($title)
        ],
        array_filter(
            array_map(
                function ($page) use ($parser, $file, $month) {
                    $textFromPdf = getTextFromPdf($parser, $file, $page);
                    return strlen($textFromPdf) < 400
                        ? null
                        : [
                            "date" => getAssignmentDate($textFromPdf, $month),
                            5 => getAssignment(5, $textFromPdf),
                            6 => getAssignment(6, $textFromPdf),
                            7 => getAssignment(7, $textFromPdf),
                        ];
                },
                range(1, 6)
            ),
            function ($value) {
                return !empty($value);
            }
        )
    );
}
