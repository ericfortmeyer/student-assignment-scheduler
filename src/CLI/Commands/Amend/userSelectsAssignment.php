<?php

namespace StudentAssignmentScheduler\CLI\Commands\Amend;

use \Ds\{
    Map,
    Vector
};

function userSelectsAssignment(array $monthOfAssignments): array
{
    [$LookupTable, $ListOfAssignments] = (function (Vector $ListOfAssignments, Vector $Original): array {
        $LookupTable = new Map();
        foreach ($Original as $first_step => $week) {
            foreach ($week as $last_step => $assignment) {
                $ListOfAssignments->push($assignment);
                $keyInList = $ListOfAssignments->count() - 1;
                $pathToOriginal = [$first_step, $last_step];
                $LookupTable->put($keyInList, $pathToOriginal);
            }
        }
        return [$LookupTable, $ListOfAssignments];
    })(new Vector(), new Vector($monthOfAssignments));

    $userSelectedAssignmentIndex = -1;

    while (!$LookupTable->hasKey($userSelectedAssignmentIndex)) {
        print_r($ListOfAssignments);
        $userSelectedAssignmentIndex = (int) readline(
            "Select the assignment that needs to be changed by entering the number to"
                . " the left of it: "
        );
    }

    [$first_step, $last_step] = $pathToOriginal = $LookupTable[$userSelectedAssignmentIndex];
    $original_key = $last_step;
    
    return [
        $original_key => $monthOfAssignments[$first_step][$last_step]
    ];
}
