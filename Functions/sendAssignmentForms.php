<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\MailSender;
use StudentAssignmentScheduler\Classes\ListOfContacts;
use function StudentAssignmentScheduler\Functions\CLI\red;
use function StudentAssignmentScheduler\Functions\Logging\emailLogger;

define(
    "NO_ASSIGNMENT_FORMS_ERROR_MSG",
    red("Oops! It looks like there are no assignment forms to send.\r\nABORT\r\n")
);

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
    ListOfContacts $ListOfContacts,
    array $contacts,
    string $path_to_forms
) {

    $list_of_contacts = loadContacts($contacts, $ListOfContacts);

    $log = emailLogger(__FUNCTION__);

    array_map(
        function (string $file) use ($MailSender, $list_of_contacts, $log, $path_to_forms) {
            try {
                $contact = $list_of_contacts->getContactByFirstName(
                    firstNameFromFilename($file)
                );

                if (!$contact) {
                    $message = firstNameFromFilename($file) . " could not be found in your list"
                        . " of contacts.  Please add their name and email address"
                        . " to your list of contacts and try running the script again.";

                    throw new \Exception($message);
                }
    
                $attachment = "$path_to_forms/$file";
    
                $MailSender
                    ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's your next assignment.\r\n\r\nThanks!")
                    ->withRecipient($contact->emailAddress(), $contact->fullname())
                    ->addAttachment($attachment)
                    ->send();
    
                echo "Email sent: {$contact->emailAddress()}\r\n";

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
                unlink($attachment);

                $log->info(
                    "Assignment slip deleted"
                );
            } catch (\Throwable $e) {
                echo "EMAIL SEND FAILURE: {$e->getMessage()}\r\n";
                $log->error(
                    "Email not sent to {email_address}. Reason: {error_message}",
                    [
                            "email_address" => $contact ? $contact->emailAddress() : "NOT CONFIGURED",
                            "error_message" => $e->getMessage()
                        ]
                );
            }
        },
        filenamesInDirectory(
            $path_to_forms,
            NO_ASSIGNMENT_FORMS_ERROR_MSG,
            true
        )
    );
}
