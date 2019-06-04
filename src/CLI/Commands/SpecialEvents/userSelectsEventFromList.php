<?php

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\{
    SpecialEvent,
    Persistence\ImmutableModifiablePersistenceInterface
};

use function StudentAssignmentScheduler\CLI\red;

/**
 * User interacts from the command line to select an event from a list.
 *
 * @param string $action
 * @param ImmutableModifiablePersistenceInterface $SpecialEventHistory
 * @return SpecialEvent
 */
function userSelectsEventFromList(
    string $action,
    ImmutableModifiablePersistenceInterface $SpecialEventHistory
): SpecialEvent {
    $userInput = userSelects($action, $SpecialEventHistory->toArray());
    $inputIsValid = function ($userInput, $SpecialEventHistory): bool {
        return is_numeric($userInput) && $SpecialEventHistory->asMap()->hasKey((int) $userInput);
    };
    $getTheEvent = function ($userInput, $SpecialEventHistory): SpecialEvent {
        return $SpecialEventHistory->asMap()->get((int) $userInput);
    };
    $retry = function ($userInput, string $action, $SpecialEventHistory): SpecialEvent {
        print PHP_EOL . PHP_EOL . PHP_EOL;
        print "\"${userInput}\"" . red(" is incorrect") . PHP_EOL;
        return userSelectsEventFromList($action, $SpecialEventHistory);
    };

    return $inputIsValid($userInput, $SpecialEventHistory)
        ? $getTheEvent($userInput, $SpecialEventHistory)
        : $retry($userInput, $action, $SpecialEventHistory);
}
