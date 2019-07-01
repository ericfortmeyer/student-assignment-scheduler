<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Commands\Functions;


use function StudentAssignmentScheduler\Persistence\Functions\register;
use function StudentAssignmentScheduler\Querying\Functions\fetchSpecialEvents;
use StudentAssignmentScheduler\Guid;
use StudentAssignmentScheduler\SpecialEvent;

function removeSpecialEvent(Guid $guid): bool
{
    $special_events = fetchSpecialEvents();

    return $special_events
        ->findByGuid($guid)
        ->onSuccess(
            function (SpecialEvent $event) use ($special_events): bool {
                $partialFunc = register($special_events->remove($event));
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
