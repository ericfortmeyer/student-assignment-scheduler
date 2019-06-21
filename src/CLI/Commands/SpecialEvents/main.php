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

use function StudentAssignmentScheduler\Utils\Functions\getConfig;
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\CLI\green;
use StudentAssignmentScheduler\{
    SpecialEventHistory,
    Destination,
    Persistence\SpecialEventHistoryRegistry
};
use \Ds\Vector;

function main(string $command)
{
    $config = getConfig();
    $specialEvents = $config["special_events"];

    // keep persistance layer immutable for easily adding undo later
    // use a registry of names of "histories"
    $filename_of_registry = $config["special_events_registry_filename"];

    $special_events_directory = $config["special_events_location"];

    // for new installations and upgrades we'll have to make the directory
    !file_exists($special_events_directory) && mkdir($special_events_directory, 0700);

    // the registry is a stream of histories persisted immutably
    $location_of_registry_of_special_events_history_filenames = buildPath(
        $config["special_events_location"],
        $filename_of_registry
    );

    $SpecialEventHistoryRegistry = new SpecialEventHistoryRegistry(
        $location_of_registry_of_special_events_history_filenames,
        new Destination($config["special_events_location"])
    );

    $SpecialEventHistory = $SpecialEventHistoryRegistry->latest();
    
    $selectedCommand = commandMap()->get(
        $command,
        actionIfNoValidCommandIsGiven($SpecialEventHistory)
    );

    $registerResult = $selectedCommand($SpecialEventHistory, $config["special_events"]);

    $registerResult($SpecialEventHistoryRegistry);
}

function actionIfNoValidCommandIsGiven(SpecialEventHistory $SpecialEventHistory): \Closure
{
    return function ($SpecialEventHistory): \Closure {
        listHistory($SpecialEventHistory);
        print "Available commands are:" . PHP_EOL . PHP_EOL;
        (new Vector(commandMap()->keys()))->apply(function (string $command_name) {
            print "  " . green($command_name) . PHP_EOL;
        });
        print PHP_EOL;

        return function (SpecialEventHistoryRegistry $registry) {
            // noop
        };
    };
}
