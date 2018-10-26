<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use TalkSlipSender\Contact;

function sendSchedule(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $schedule_recipients,
    array $contacts,
    string $schedule_filename
) {
    array_map(
        function (string $recipient) use (
            $MailSender,
            $ListOfContacts,
            $contacts,
            $schedule_filename)
        {
            $contact = loadContacts($contacts, $ListOfContacts)
                ->getContactByFullname(
                    ...splitFullName($recipient)
                );

            try {
                $MailSender
                    ->addSubject("Schedule for next month")
                    ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's the schedule for next month.\r\n\r\nThanks!")
                    ->addAddress($contact->emailAddress(), $contact->fullname())
                    ->addAttachment($schedule_filename)
                    ->send();

                echo "Email sent\r\n";

            } catch (\Exception $e) {
                echo "EMAIL SEND FAILURE: {$e->getMessage()}";
            }
            
        },
        $schedule_recipients
    );
}
