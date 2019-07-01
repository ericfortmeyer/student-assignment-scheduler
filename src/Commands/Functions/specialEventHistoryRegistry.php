<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Commands\Functions;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;
use StudentAssignmentScheduler\{
    Destination,
    Persistence\SpecialEventHistoryRegistry
};

function specialEventHistoryRegistry(): SpecialEventHistoryRegistry
{
    $config = getConfig();

    // keep persistance layer immutable for easily adding undo later
    // use a registry of names of "histories"
    $filename_of_registry = $config["special_events_registry_filename"];

    // the registry is a stream of histories persisted immutably
    $location_of_registry_of_special_events_history_filenames = buildPath(
        $config["special_events_location"],
        $filename_of_registry
    );

    return new SpecialEventHistoryRegistry(
        $location_of_registry_of_special_events_history_filenames,
        new Destination($config["special_events_location"])
    );
}
