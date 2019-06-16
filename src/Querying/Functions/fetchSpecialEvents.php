<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\Persistence\SpecialEventHistoryRegistry;
use StudentAssignmentScheduler\Destination;

use function StudentAssignmentScheduler\Utils\Functions\{
    getConfig,
    buildPath
};

function fetchSpecialEvents()
{
    $config = getConfig();
    $specialEvents = $config["special_events"];

    // keep persistance layer immutable for easily adding undo later
    // use a registry of names of "histories"
    $filename_of_registry = $config["special_events_registry_filename"];

    $special_events_directory = $config["special_events_location"];

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

    return $SpecialEventHistory->getArrayCopy();
}
