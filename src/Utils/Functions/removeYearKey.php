<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

use \Ds\{
    Vector,
    Map
};

function removeYearKey(array $monthOfAssignments): array
{
    return (new Vector($monthOfAssignments))->map(function (array $weekOfAssignments): array {
        return (new Map($weekOfAssignments))->filter(
            function ($key, $value) {
                return $key !== "year";
            }
        )->toArray();
    })->toArray();
}
