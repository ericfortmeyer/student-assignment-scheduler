<?php

namespace StudentAssignmentScheduler\Commands\Functions;

use StudentAssignmentScheduler\ListOfContacts;
use StudentAssignmentScheduler\ListOfScheduleRecipients;

use \Ds\Map;

function getNameByType(string $type): string
{
    $map_of_names_to_types = new Map(
        [
            ListOfContacts::class => function ($type) {
                return "contacts";
            },
            ListOfScheduleRecipients::class => function ($type) {
                return "schedule_recipients";
            }
        ]
    );

    return $map_of_names_to_types->get(
        $type,
        function (string $type) {
            throw new \InvalidArgumentException(sprintf(
                "%s is not a valid list of type",
                $type
            ));
        }
    )($type);
}
