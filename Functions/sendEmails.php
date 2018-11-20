<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;

function sendEmails(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $contacts,
    string $assignment_forms_destination,
    array $schedule_recipients,
    string $schedule_filename
) {

    $clone_of_mail_sender = clone $MailSender;
    $clone_of_list_of_contacts = clone $ListOfContacts;

    sendAssignmentForms(
        $MailSender,
        $ListOfContacts,
        $contacts,
        __DIR__ . "/../{$assignment_forms_destination}"
    );


    sendSchedule(
        $clone_of_mail_sender,
        $clone_of_list_of_contacts,
        $schedule_recipients,
        $contacts,
        $schedule_filename
    );
}
