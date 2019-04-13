<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\MailSender;
use StudentAssignmentScheduler\Classes\ListOfContacts;

function sendEmails(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
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
        $assignment_forms_destination
    );


    sendSchedule(
        $clone_of_mail_sender,
        $clone_of_list_of_contacts,
        $schedule_recipients,
        $schedule_filename
    );
}
