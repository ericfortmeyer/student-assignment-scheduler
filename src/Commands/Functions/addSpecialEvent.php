<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Commands\Functions;


use function StudentAssignmentScheduler\Persistence\Functions\register;
use function StudentAssignmentScheduler\Querying\Functions\fetchSpecialEvents;
use StudentAssignmentScheduler\SpecialEvent;

function addSpecialEvent(SpecialEvent $special_event_to_add): bool
{
    $special_events = fetchSpecialEvents();
    $partialFunc = register($special_events->with($special_event_to_add));
    $partialFunc(specialEventHistoryRegistry());

    return true;
}
