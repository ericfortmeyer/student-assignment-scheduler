<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\Classes\{
    SpecialEventHistory,
    SpecialEvent
};

use function StudentAssignmentScheduler\Functions\CLI\red;

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