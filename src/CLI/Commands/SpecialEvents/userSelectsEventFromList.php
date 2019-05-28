<?php

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\{
    SpecialEventHistory,
    SpecialEvent
};
// use StudentAssignmentScheduler\{
//     SpecialEventHistory,
//     SpecialEvent
// };

use function StudentAssignmentScheduler\CLI\red;

function userSelectsEventFromList(string $action, SpecialEventHistory $SpecialEventHistory): SpecialEvent
{
    $userInput = userSelects($action, $SpecialEventHistory->toArray());

    return is_numeric($userInput) && $SpecialEventHistory->asMap()->hasKey((int) $userInput)
        ? $SpecialEventHistory->asMap()->get((int) $userInput)
        : (function ($userInput, string $action, SpecialEventHistory $SpecialEventHistory) {
            print PHP_EOL . PHP_EOL . PHP_EOL;
            print "\"${userInput}\"" . red(" is incorrect") . PHP_EOL;
            return userSelectsEventFromList($action, $SpecialEventHistory);
        })($userInput, $action, $SpecialEventHistory);
}
