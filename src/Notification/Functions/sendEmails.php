<?php

namespace StudentAssignmentScheduler\Notification\Functions;

use StudentAssignmentScheduler\Notification\MailSender;
use StudentAssignmentScheduler\ListOfContacts;
use StudentAssignmentScheduler\ListOfScheduleRecipients;
use Psr\Log\LoggerInterface;
use \Ds\Set;
use \Ds\Vector;
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;

/**
 * Sends assignment forms and schedules
 *
 * @param MailSender $MailSender
 * @param ListOfContacts $ListOfContacts
 * @param string $assignment_forms_destination
 * @param ListOfScheduleRecipients $schedule_recipients
 * @param string $schedule_filename
 * @param LoggerInterface $logger
 * @return void
 */
function sendEmails(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    string $assignment_forms_destination,
    ListOfScheduleRecipients $schedule_recipients,
    string $schedule_filename,
    LoggerInterface $logger
): void {

    /**
     * Clone these classes since they are mutated by the functions using them
     * making their behavior unpredictable to functions using them afterwards
     */
    $clone_of_mail_sender = clone $MailSender;
    $clone_of_list_of_contacts = clone $ListOfContacts;

    $appendDestinationToFilename = function (string $basename) use ($assignment_forms_destination): string {
        return buildPath($assignment_forms_destination, $basename);
    };

    sendAssignmentForms(
        $MailSender,
        filenamesMappedToTheirRecipient(
            new Set(
                (new Vector(filenamesInDirectory($assignment_forms_destination)))
                    ->map($appendDestinationToFilename)
            ),
            $ListOfContacts
        ),
        $logger
    );


    sendSchedule(
        $clone_of_mail_sender,
        $clone_of_list_of_contacts,
        $schedule_recipients,
        $schedule_filename,
        $logger
    );
}
