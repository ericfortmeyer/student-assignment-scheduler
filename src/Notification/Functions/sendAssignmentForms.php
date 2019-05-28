<?php

namespace StudentAssignmentScheduler\Notification\Functions;

use StudentAssignmentScheduler\Notification\MailSender;
use StudentAssignmentScheduler\Contact;
use Psr\Log\LoggerInterface;
use \Ds\Map;

/**
 * Sends assignment forms
 *
 * For each file found in the assignment form folder
 * (1) Use the name of the assignment folder to determine who the recipient is
 * (2) Attach file and send email to the recipient
 * (3) Delete the file from the folder
 */
function sendAssignmentForms(
    MailSender $MailSender,
    Map $MapOfAttachmentFilenamesToTheirRecipients,
    LoggerInterface $logger,
    bool $test_mode = false
): bool {

    $log = $logger;

    $emailAssignmentForms = function (
        string $filename_of_attachment,
        Contact $contact
    ) use (
        $MailSender,
        $log,
        $test_mode
    ) {
        try {
            $MailSender
                ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's your next assignment.\r\n\r\nThanks!")
                ->withRecipient($contact->emailAddress(), $contact->fullname())
                ->addAttachment($filename_of_attachment)
                ->send();

            $test_mode || print "Email sent: {$contact->emailAddress()}\r\n";

            $log->info(
                "Email sent: {email_address}",
                ["email_address" => $contact->emailAddress()]
            );

            /**
             * Delete attachment
             *
             * Since assignment slips are created and this function is called each time the script is run,
             * the file needs to be deleted or duplicates will be created
             */
            unlink($filename_of_attachment);

            $log->info(
                "Assignment slip deleted"
            );
        } catch (\Throwable $e) {
            return false;
        }
    };

    $MapOfAttachmentFilenamesToTheirRecipients->map($emailAssignmentForms);
    return true;
}