<?php

namespace TalkSlipSender\Functions\CLI;

function createBibleReading(string $date): array
{
    $assignment = "bible_reading";
    echo heading($assignment);
    return createAssignment(
        $date,
        $assignment,
        readline("Enter student's name: "),
        readline("Enter counsel point: "),
        ""
    );
}
