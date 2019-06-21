<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

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
