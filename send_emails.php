<?php

use TalkSlipSender\MailSender;
use TalkSlipSender\ListOfContacts;
use TalkSlipSender\Contact;
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

use function TalkSlipSender\loadContacts;

require "vendor/autoload.php";
require "loadContacts.php";
require "Contact.php";
require "ListOfContacts.php";
require "MailSender.php";

/**
 * Path to files that will be attached to the emails
 */
$path = realpath($argv[1] ?? "");

/**
 * Get the email address of sender
 */
$config = include("config.php");
$from_email = $config["from_email"];

/**
 * Get the password of the sender's email account
 */
(new Dotenv(realpath(__DIR__)))->load();
$from_email_password = getenv("from_email_password");


array_map(
    function ($file) use ($path, $from_email, $from_email_password) {
        try {
            /**
             * A contact object
             * @var Contact $contact
             */
            $contact = loadContacts(require "contacts.php", new ListOfContacts())
                ->getContactByFirstName(
                    /**
                     * Extract first name of contact from filename
                     * where filename has a suffix like JOHN_2
                     */
                    current(
                        explode(
                            "_",
                            /**
                             * Extract first name of contact from filename
                             * by removing file extension
                             */
                            str_replace(".pdf", "", $file)
                        )
                    )
                );

            /**
             * The file that should be attached to the email
             * @var string $attachment
             */
            $attachment = "$path/$file";

            (new MailSender(new PHPMailer(true), $from_email, $from_email_password))
                ->addBody("Dear {$contact->firstName()},\r\n\r\nHere's your next assignment.\r\n\r\nThanks!")
                ->addAddress($contact->emailAddress(), $contact->fullname())
                ->addAttachment($attachment)
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
