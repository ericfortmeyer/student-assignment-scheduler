<?php

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use TalkSlipSender\Contact;
use PHPMailer\PHPMailer\PHPMailer;

require "vendor/autoload.php";
require "loadContacts.php";
require "Contact.php";
require "ListOfContacts.php";
require "MailSender.php";

$path = realpath($argv[1] ?? "");

array_map(
    function ($file) use ($path) {
        try {
            $contact = TalkSlipSender\loadContacts(require "contacts.php", new ListOfContacts())
                ->getContactByFirstName(str_replace(".pdf", "", $file));

            (new MailSender(new PHPMailer(true)))
                ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's your next assignment.\r\n\r\nThanks!")
                ->addAddress($contact->get(Contact::EMAIL), $contact->fullname())
                ->addAttachment("$path/$file")
                ->send();

            echo "Email sent\r\n";
        } catch (Exception $e) {
            echo "{$e->getMessage()}";
            echo "failed\r\n";
        }
    },
    array_filter(
        scandir($path),
        function ($file) {
            return !in_array($file, [".", "..", ".DS_Store"]);
        }
    )
);
