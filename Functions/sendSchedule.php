<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\MailSender;
use TalkSlipSender\Models\ListOfContacts;

use function TalkSlipSender\Functions\Logging\emailLogger;

function sendSchedule(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $schedule_recipients,
    array $contacts,
    string $schedule_filename
) {
    $list_of_contacts = loadContacts($contacts, $ListOfContacts);

    $log = emailLogger(__FUNCTION__);

    array_map(
        function (string $recipient) use (
            $MailSender,
            $list_of_contacts,
            $log,
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
                $log->info(
                    "Email sent: {email_address}",
                    ["email_address" => $contact->emailAddress()]
                );
            } catch (\Exception $e) {
                echo "EMAIL SEND FAILURE: {$e->getMessage()}\r\n";
                $log->error(
                    "Email not sent to {email_address}. Reason: {error_message}",
                    [
                            "email_address" => $contact->emailAddress(),
                            "error_message" => $e->getMessage()
                        ]
                );
            }
        },
        $schedule_recipients
    );
}
