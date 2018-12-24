<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Models\Contact;
use StudentAssignmentScheduler\Models\ListOfContacts;

function loadContacts(array $contacts, ListOfContacts $list_of_contacts)
{
    array_map(
        function (string $contact_info) use ($list_of_contacts) {
            $info = explode(" ", $contact_info);
            $contact = new Contact();
            $contact->addFirstName($info[0]);
            $contact->addLastName($info[1]);
            $contact->addEmailAddress($info[2]);
            $list_of_contacts->addContact($contact);
        },
        $contacts
    );
    return $list_of_contacts;
}
