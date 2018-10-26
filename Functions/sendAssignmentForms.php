<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use TalkSlipSender\Contact;

function sendAssignmentForms(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $contacts,
    string $path_to_forms
) {            
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
        array_diff(
            scandir($path_to_forms),
            [".", "..", ".DS_Store"]
        )
    );
}
