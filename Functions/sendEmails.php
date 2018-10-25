<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use TalkSlipSender\Contact;

function sendEmails(
    MailSender $MailSender,
    ListOfContacts $ListOfContacts,
    array $config,
    array $contacts
) {
    /**
     * Path to files that will be attached to the emails
     */
    $path_to_forms = __DIR__ . "/../{$config["assignment_forms_destination"]}";
            
    array_map(
        function (string $file) use ($MailSender, $ListOfContacts, $contacts, $path_to_forms) {
            try {
                /**
                 * A contact object
                 * @var Contact $contact
                 */
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
    
                echo "Email sent\r\n";
            } catch (\Exception $e) {
                echo "{$e->getMessage()}";
                echo "failed\r\n";
            }
        },
        array_diff(
            scandir($path_to_forms),
            [".", "..", ".DS_Store"]
        )
    );
}
