<?php

namespace TalkSlipSender\Functions;

use Smalot\PdfParser\Parser;

function extractDataFromPdf(Parser $parser, string $file, string $interval_spec): array
{
    $title = getDetailsFromPdf($parser, $file)["Title"];

    return array_merge(
        [
            "month" => $month = getMonthFromTitle($title),
            "year" => getYearFromTitle($title)
        ],
        array_filter(
            array_map(
                function ($page) use ($parser, $file, $month, $interval_spec) {
                    $textFromPdf = getTextFromPdf($parser, $file, $page);
                    $pdf_page_does_not_have_schedule = strlen($textFromPdf) < 400;
                    return $pdf_page_does_not_have_schedule
                        ? null
                        : [
                            "date" => getAssignmentDate($textFromPdf, $month, $interval_spec),
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
