<?php

namespace StudentAssignmentScheduler;

use \Ds\Set;

final class ListOfScheduleRecipients extends ListOfContacts
{
    public function __construct(array $contacts)
    {
        $this->contacts = new Set(
            array_map(
                function (string $contact_info): ScheduleRecipient {
                    return new ScheduleRecipient($contact_info);
                },
                $contacts
            )
        );
    }
}
