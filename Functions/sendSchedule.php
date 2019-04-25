<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\MailSender;
use StudentAssignmentScheduler\Classes\{
    ListOfContacts,
    ListOfScheduleRecipients,
    ScheduleRecipient,
    Fullname
};

use function StudentAssignmentScheduler\Functions\Logging\emailLogger;

function sendSchedule(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    ListOfScheduleRecipients $schedule_recipients,
    string $schedule_filename
) {
    $log = emailLogger(__FUNCTION__);

    array_map(
        function (ScheduleRecipient $recipient) use (
            $MailSender,
            $ListOfContacts,
            $log,
            $schedule_filename
        ) {
            $contact = $ListOfContacts->findByFullname(
                new Fullname($recipient->firstName(), $recipient->lastName())
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
        $schedule_recipients->toArray()
    );
}
