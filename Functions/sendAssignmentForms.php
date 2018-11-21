<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use function TalkSlipSender\Functions\CLI\red;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;

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

    $list_of_contacts = loadContacts($contacts, $ListOfContacts);

    $log = new Logger(__FUNCTION__);
    $log->pushHandler(new StreamHandler(__DIR__ . "/../log/email.log"));
    $log->pushProcessor(new PsrLogMessageProcessor());

    array_map(
        function (string $file) use ($MailSender, $list_of_contacts, $log, $path_to_forms) {
            try {
                $contact = $list_of_contacts->getContactByFirstName(
                    firstNameFromFilename($file)
                );
    
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
        filenamesInDirectory(
            $path_to_forms,
            NO_ASSIGNMENT_FORMS_ERROR_MSG,
            true
        )
    );
}
