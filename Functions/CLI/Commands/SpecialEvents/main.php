<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use \Ds\Vector;

use function StudentAssignmentScheduler\Functions\{
    getConfig,
    buildPath,
    CLI\green
};

use StudentAssignmentScheduler\Classes\{
    SpecialEventHistory,
    SpecialEventHistoryRegistry,
    Destination,
};


function main(string $command)
{
    $config = getConfig();
    $specialEvents = $config["special_events"];

    // keep persistance layer immutable for easily adding undo later
    // use a registry of names of "histories"
    $filename_of_registry = \base64_encode("registry");

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
