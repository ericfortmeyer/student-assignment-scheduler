<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\MailSender;
use TalkSlipSender\Models\ListOfContacts;

function sendEmails(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $contacts,
    string $assignment_forms_destination,
    array $schedule_recipients,
    string $schedule_filename
) {

    /**
     * Clone these classes since they are mutated by the functions using them
     * making their behavior unpredictable to functions using them afterwards
     */
    $clone_of_mail_sender = clone $MailSender;
    $clone_of_list_of_contacts = clone $ListOfContacts;

    sendAssignmentForms(
        $MailSender,
        $ListOfContacts,
        $contacts,
        $assignment_forms_destination
    );


    sendSchedule(
        $clone_of_mail_sender,
        $clone_of_list_of_contacts,
        $schedule_recipients,
        $contacts,
        $schedule_filename
    );
}
