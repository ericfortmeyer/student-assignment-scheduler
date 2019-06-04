<?php

namespace StudentAssignmentScheduler\Notification\Functions;

use StudentAssignmentScheduler\Notification\MailSender;
use StudentAssignmentScheduler\{
    ListOfContacts,
    ListOfScheduleRecipients,
    ScheduleRecipient,
    Fullname
};
use Psr\Log\LoggerInterface;

function sendSchedule(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    ListOfScheduleRecipients $schedule_recipients,
    string $schedule_filename,
    LoggerInterface $logger
) {
    $log = $logger;

    array_map(
        function (ScheduleRecipient $recipient) use (
            $MailSender,
            $ListOfContacts,
            $log,
            $schedule_filename
        ) {
            $doIfContactNotFound = function () use ($recipient, $log): bool {
                $log->error(
                    "Contact not found: {fullname_of_intended_recipient}",[
                        "fullname_of_intended_recipient" => (string) new Fullname(
                            $recipient->firstName(),
                            $recipient->lastName()
                        )
                    ]
                );
                return false;
            };
            $result = $ListOfContacts
                ->findByFullname(new Fullname($recipient->firstName(), $recipient->lastName()))
                ->getOrElse($doIfContactNotFound);

            if ($result === false) {
                return false;
            } else {
                $contact = $result;
            }

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
        $schedule_recipients->toArray()
    );
}
