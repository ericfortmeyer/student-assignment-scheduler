<?php

namespace StudentAssignmentScheduler\Commands\Functions;

use StudentAssignmentScheduler\ListOfContacts;
use StudentAssignmentScheduler\ListOfScheduleRecipients;

use \Ds\Map;

function getInstanceByType(string $type, $args): ListOfContacts
{
    $map_of_names_to_types = new Map(
        [
            ListOfContacts::class => function ($type, $args) {
                return new ListOfContacts($args);
            },
            ListOfScheduleRecipients::class => function ($type, $args) {
                return new ListOfScheduleRecipients($args);
            }
        ]
    );

    return $map_of_names_to_types->get(
        $type,
        function ($type) {
            throw new \InvalidArgumentException(sprintf(
                "%s is not a valid list of type",
                $type
            ));
        }
    )($type, $args);
}
