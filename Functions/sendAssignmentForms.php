<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use function TalkSlipSender\Functions\CLI\red;

function sendAssignmentForms(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $contacts,
    string $path_to_forms
) {
    
    define(
        "NO_ASSIGNMENT_FORMS_ERROR_MSG",
        red("Oops! It looks like there are no assignment forms to send.\r\nABORT\r\n")
    );
    
    array_map(
        function (string $file) use ($MailSender, $ListOfContacts, $contacts, $path_to_forms) {
            try {
                $contact = loadContacts($contacts, $ListOfContacts)
                    ->getContactByFirstName(
                        firstNameFromFilename($file)
                    );
    
                $attachment = "$path_to_forms/$file";
    
                $MailSender
                    ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's your next assignment.\r\n\r\nThanks!")
                    ->addAddress($contact->emailAddress(), $contact->fullname())
                    ->addAttachment($attachment)
                    ->send();
    
                echo "Email sent: {$contact->emailAddress()}\r\n";
            } catch (\Exception $e) {
                echo "EMAIL SEND FAILURE: {$e->getMessage()}\r\n";
            }
        },
        filenamesInDirectory(
            $path_to_forms,
            NO_ASSIGNMENT_FORMS_ERROR_MSG,
            true
        )
    );
}
