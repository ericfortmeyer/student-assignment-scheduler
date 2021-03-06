<?php

namespace StudentAssignmentScheduler\Notification;

use PHPUnit\Framework\TestCase;
use PHPMailer\PHPMailer\PHPMailer;
use tm\MockExternService\{
    Service,
    Result
};
use StudentAssignmentScheduler\{
    ListOfContacts,
    Fullname,
    Contact
};
use \Ds\Set;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;
use function StudentAssignmentScheduler\Notification\Functions\{
    sendAssignmentForms,
    filenamesMappedToTheirRecipient
};
use function StudentAssignmentScheduler\FileNaming\Functions\assignmentFormFilename;
use function StudentAssignmentScheduler\Logging\Functions\nullLogger;

class NotificationHandlingTest extends TestCase
{
    public function testMockEmailServerReceivedEmail()
    {
        Service::boot();

        $EmptyMailer = new PHPMailer();

        $Mailer = clone $EmptyMailer;

        $MailSender = new MailSender(
            $EmptyMailer,
            "root@127.0.0.1",
            "fake_password",
            "root@127.0.0.1"
        );

        $Mailer->Sendmail = ini_get("sendmail_path");
        $Mailer->setFrom("fake@mail.me");
        $Mailer->addAddress("e.fortmeyer01@gmail.com");
        $Mailer->Subject = "Nothing really important";
        $msg = $Mailer->Body = "Content " . time();

        $MailSender->withMailer($Mailer)->send();

        $this->assertStringContainsString(
            $msg,
            Result::MailInbox()
        );
    }

    public function testSendsEmailWithAssignmentFormsAttached()
    {
        $Mailer = new PHPMailer();

        $MailSender = new MailSender(
            new PHPMailer(),
            "root@127.0.0.1",
            "fake_password",
            "root@127.0.0.1"
        );

        $Mailer->Sendmail = ini_get("sendmail_path");
        $Mailer->setFrom("fake@mail.me");
        $Mailer->addAddress("e.fortmeyer01@gmail.com");
        $Mailer->Subject = "Nothing really important";
        $msg = $Mailer->Body = "Content " . time();

        $fullname = new Fullname("eric", "fortmeyer");

        $ListOfContacts = new ListOfContacts([
            $contact = new Contact("${fullname} e.fortmeyer01@gmail.com")
        ]);

        $dir_to_forms = buildPath(
            __DIR__,
            "..",
            "tmp"
        );

        $filename = buildPath(
            $dir_to_forms,
            assignmentFormFilename(
                $fullname,
                $ListOfContacts
            )
        );

        // or we can use writeAssignmentFormFromAssignment
        file_put_contents($filename, "fake data");
        $this->setOutputCallback(function () {
        });

        sendAssignmentForms(
            $MailSender->withMailer($Mailer),
            filenamesMappedToTheirRecipient(
                new Set([$filename]),
                $ListOfContacts
            ),
            nullLogger()
        );

        $result = $ListOfContacts->findByFullname($fullname);
        $Recipient = $result->getOrElse(
            function (): bool {
                return false;
            }
        );

        $id_of_recipient = (string) $Recipient->guid();

        $this->assertStringContainsString(
            "Dear Eric",
            Result::MailInbox()
        );

        $this->assertStringContainsString(
            "Thanks!",
            Result::MailInbox()
        );

        $this->assertStringContainsString(
            sha1($id_of_recipient),
            Result::MailInbox()
        );

        $sha1_of_id_of_recipient = sha1($id_of_recipient);
        $this->assertStringContainsString(
            "Content-Type: application/pdf; name=\"${sha1_of_id_of_recipient}.pdf\"",
            Result::MailInbox()
        );

        $this->assertStringContainsString(
            "Content-Disposition: attachment; filename=" . basename($filename),
            Result::MailInbox()
        );
    }
}
