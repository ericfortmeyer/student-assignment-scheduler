<?php

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

// use StudentAssignmentScheduler\SpecialEventType;
use StudentAssignmentScheduler\SpecialEventType;
use \Ds\Map;
use function StudentAssignmentScheduler\CLI\red;

function userSelectsEventTypeFromList(iterable $list_of_events): SpecialEventType
{
    $userInput = userSelects("scheduling", $list_of_events);

    $ListOfEvents = new Map($list_of_events);

    return userInputIsKeyOfEvent($ListOfEvents, $userInput)
        ? new SpecialEventType($list_of_events, $ListOfEvents->get((int)$userInput))
        : (
            userInputIsEventName($ListOfEvents, $userInput)
                ? new SpecialEventType($list_of_events, ucwords($userInput))
                : (function ($userInput, iterable $list_of_events): SpecialEventType {
                    print PHP_EOL . PHP_EOL . PHP_EOL;
                    print "\"${userInput}\"" . red(" is incorrect") . PHP_EOL;
                    return userSelectsEventTypeFromList($list_of_events);
                })($userInput, $list_of_events)
            );
}

function userInputIsKeyOfEvent(Map $ListOfEvents, $userInput): bool
{
    return \is_numeric($userInput) && $ListOfEvents->hasKey((int)$userInput);
}

function userInputIsEventName(Map $ListOfEvents, $userInput): bool
{
    return $ListOfEvents->hasValue(ucwords($userInput));
}
