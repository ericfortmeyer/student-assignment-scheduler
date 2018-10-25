<?php

namespace TalkSlipSender\Functions\CLI;

use function TalkSlipSender\Functions\monthOfAssignments;

function displayTableOfMonthOfAssignments(
    string $month,
    string $path_to_assignments_files
): bool {
    return array_reduce(
        array_map(
            function (array $week_of_assignments) {
                return displayTableOfData($week_of_assignments);
            },
            monthOfAssignments($month)($path_to_assignments_files)
        ),
        function ($carry, $result) {
            return $carry || $result;
        }
    ) ?? false;
}
