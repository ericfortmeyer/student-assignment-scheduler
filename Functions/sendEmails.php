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


    sendAssignmentForms(
        $MailSender,
        $ListOfContacts,
        $contacts,
        __DIR__ . "/../{$assignment_forms_destination}"
    );


    sendSchedule(
        $MailSender,
        $ListOfContacts,
        $schedule_recipients,
        $contacts,
        $schedule_filename
    );
}
