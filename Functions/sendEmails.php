<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\MailSender;
use StudentAssignmentScheduler\Classes\{
    ListOfContacts,
    ListOfScheduleRecipients
};

use \Ds\{
    Set,
    Vector
};

function sendEmails(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    string $assignment_forms_destination,
    ListOfScheduleRecipients $schedule_recipients,
    string $schedule_filename
) {

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
        )
    );


    sendSchedule(
        $clone_of_mail_sender,
        $clone_of_list_of_contacts,
        $schedule_recipients,
        $schedule_filename
    );
}
