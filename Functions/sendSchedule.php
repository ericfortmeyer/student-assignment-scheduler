<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;

function sendSchedule(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $schedule_recipients,
    array $contacts,
    string $schedule_filename
) {
    $list_of_contacts = loadContacts($contacts, $ListOfContacts);

    array_map(
        function (string $recipient) use (
            $MailSender,
            $list_of_contacts,
            $schedule_filename
        ) {
            $contact = $list_of_contacts->getContactByFullname(
                ...splitFullName($recipient)
            );

            try {
                $MailSender
                    ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's the schedule for next month.\r\n\r\nThanks!")
                    ->withRecipient($contact->emailAddress(), $contact->fullname())
                    ->addSubject("Schedule for next month")
                    ->addAttachment($schedule_filename)
                    ->send();

                echo "Email sent: {$contact->emailAddress()}\r\n";
            } catch (\Exception $e) {
                echo "EMAIL SEND FAILURE: {$e->getMessage()}";
            }
        },
        $schedule_recipients
    );
}
