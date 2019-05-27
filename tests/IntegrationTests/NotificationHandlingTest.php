<?php

namespace StudentAssignmentScheduler\Utils;

use PHPUnit\Framework\TestCase;

use PHPMailer\PHPMailer\PHPMailer;

use StudentAssignmentScheduler\{
    ListOfContacts,
    Fullname,
    Contact
};

use \Ds\Set;

use tm\MockExternService\{
    Service,
    Result
};

use function StudentAssignmentScheduler\Functions\{
    buildPath,
    sendAssignmentForms,
    filenamesMappedToTheirRecipient,
    Filenaming\assignmentFormFilename,
    Logging\nullLogger
};

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

        $Recipient = $ListOfContacts->findByFullname($fullname);

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
            $id_of_recipient,
            Result::MailInbox()
        );

        $this->assertStringContainsString(
            "Content-Type: application/pdf; name=\"${id_of_recipient}.pdf\"",
            Result::MailInbox()
        );

        $this->assertStringContainsString(
            "Content-Disposition: attachment; filename=" . basename($filename),
            Result::MailInbox()
        );
    }
}
