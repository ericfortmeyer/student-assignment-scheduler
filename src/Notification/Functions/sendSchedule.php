<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Notification\Functions;

use StudentAssignmentScheduler\Notification\MailSender;
use StudentAssignmentScheduler\ListOfContacts;
use StudentAssignmentScheduler\ListOfScheduleRecipients;
use StudentAssignmentScheduler\ScheduleRecipient;
use StudentAssignmentScheduler\Fullname;
use Psr\Log\LoggerInterface;

/**
 * @param MailSender $MailSender
 * @param ListOfContacts $ListOfContacts
 * @param ListOfScheduleRecipients $schedule_recipients
 * @param string $schedule_filename
 * @param LoggerInterface $logger
 * @return void
 */
function sendSchedule(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    ListOfScheduleRecipients $schedule_recipients,
    string $schedule_filename,
    LoggerInterface $logger
): void {
    array_map(
        function (ScheduleRecipient $recipient) use (
            $MailSender,
            $ListOfContacts,
            $logger,
            $schedule_filename
        ) {
            $doIfContactNotFound = function () use ($recipient, $logger): bool {
                $logger->error(
                    "Contact not found: {fullname_of_intended_recipient}",
                    [
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
                $logger->info(
                    "Email sent: {email_address}",
                    ["email_address" => $contact->emailAddress()]
                );
            } catch (\Exception $e) {
                echo "EMAIL SEND FAILURE: {$e->getMessage()}\r\n";
                $logger->error(
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
