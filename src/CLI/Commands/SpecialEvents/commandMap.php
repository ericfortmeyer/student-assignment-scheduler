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

use StudentAssignmentScheduler\{
    SpecialEventHistory,
    Persistence\SpecialEventHistoryRegistry
};
use function StudentAssignmentScheduler\Persistence\Functions\register;
use \Ds\Map;

function commandMap(): Map
{
    return new Map(
        [
            "list" => function (SpecialEventHistory $SpecialEventHistory): \Closure {
                listHistory($SpecialEventHistory);

                return function (SpecialEventHistoryRegistry $registry) {
                    // noop
                };
            },
            "edit" => function (SpecialEventHistory $SpecialEventHistory): \Closure {
                $ModifiedHistory = edit($SpecialEventHistory);

                return register($ModifiedHistory);
            },
            "remove" => function (SpecialEventHistory $SpecialEventHistory): \Closure {
                $ModifiedHistory = remove($SpecialEventHistory);

                return register($ModifiedHistory);
            },
            "add" => function (SpecialEventHistory $SpecialEventHistory, iterable $special_event_types): \Closure {
                $ModifiedHistory = add($SpecialEventHistory, $special_event_types);

                return register($ModifiedHistory);
            }
        ]
    );
}
