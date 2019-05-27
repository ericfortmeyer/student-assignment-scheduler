<?php

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use \Ds\Map;

use StudentAssignmentScheduler\{
    SpecialEventHistory,
    SpecialEventHistoryRegistry
};

use function StudentAssignmentScheduler\Functions\Persistence\register;

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
