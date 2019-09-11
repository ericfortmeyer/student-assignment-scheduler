<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Commands\Functions;


use function StudentAssignmentScheduler\Persistence\Functions\register;
use function StudentAssignmentScheduler\Querying\Functions\fetchSpecialEvents;
use StudentAssignmentScheduler\SpecialEvent;
use StudentAssignmentScheduler\Guid;

function updateSpecialEvent(Guid $id_of_original_event, SpecialEvent $event_modified): bool
{
    $special_events = fetchSpecialEvents();

    return $special_events
        ->findByGuid($id_of_original_event)
        ->onSuccess(
            function (SpecialEvent $event) use ($special_events, $event_modified): bool {
                $partialFunc = register(
                    $special_events->update($event, $event_modified)
                );
                $partialFunc(specialEventHistoryRegistry());
                return true;
            }
        )
        ->onFailure(
            function (bool $value): bool {
                return $value;
            }
        )
        ->resolve();
}
