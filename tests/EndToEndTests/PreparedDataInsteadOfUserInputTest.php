<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

use Fortmeyer\MockExternService\{
    Service,
    Result
};

use PHPMailer\PHPMailer\PHPMailer;

use function StudentAssignmentScheduler\Functions\buildPath;


class PreparedDataInsteadOfUserInputTest extends TestCase
{
    protected function setup(): void
    {
        Service::boot();

        $this->mock_schedule_basename = "fake_schedule";

        $this->assignment_forms_destination = $this->path_to_created_assignment_forms = buildPath(
            __DIR__,
            "..",
            "tmp",
            "forms"
        );

        !file_exists($this->path_to_created_assignment_forms)
            && mkdir($this->path_to_created_assignment_forms);

        $this->schedule_destination = $this->path_to_created_schedule = buildPath(
            __DIR__,
            "..",
            "tmp",
            $this->mock_schedule_basename . ".pdf"
        );

        $this->path_to_assignment_form_writer_config = buildPath(
            __DIR__,
            "..",
            "mocks",
            "config",
            "assignment_form_writer_config.php"
        );

        $this->path_to_schedule_writer_config = buildPath(
            __DIR__,
            "..",
            "mocks",
            "config",
            "schedule_writer_config.php"
        );

        $this->mock_contacts = buildPath(
            __DIR__,
            "..",
            "mocks",
            "contacts.php"
        );
    }

    public function testDocumentsAreCreatedAndAttachedToEmailsAndEmailsAreSentWhenGivenMockUserInput()
    {
        $AppTester = new Utils\AppTester();
        $schedule = $this->schedule();
        $schedule_writer_config = require $this->path_to_schedule_writer_config;
        $assignment_form_writer_config = require $this->path_to_assignment_form_writer_config;
        $assignment_form_writer_config["assignment_forms_destination"] = $this->assignment_forms_destination;
        $path_to_forms = $this->assignment_forms_destination;
        $path_to_schedule = $this->schedule_destination;
        $ListOfContacts = new ListOfContacts(require $this->mock_contacts);
        $assignment_form_filenames = new \Ds\Set();
        $mail_sender_args = [
            $EmptyMailer = new PHPMailer(),
            "nobody@fakemail.com",
            "fake_password",
            "smtp.fake_host.net"
        ];

        $Mailer = clone $EmptyMailer;

        $Mailer->Sendmail = ini_get("sendmail_path");
        $Mailer->setFrom("fake@mail.me");
        $Mailer->addAddress("e.fortmeyer01@gmail.com");
        $Mailer->Subject = "Nothing really important";
        $msg = $Mailer->Body = "Content " . time();



        $AppTester
            ->given(Utils\PdfScheduleWriter::class, $schedule_writer_config)
            ->when(
                function (Utils\PdfScheduleWriter $writer) use ($schedule) {
                    $writer->create(
                        $this->assignments(),
                        $schedule,
                        $this->mock_schedule_basename
                    );
                },
                Utils\PdfScheduleWriter::class
            )
            ->then(
                (function (PreparedDataInsteadOfUserInputTest $test) {
                    return function (string $path_to_schedule) use ($test) {
                        $test->assertFileExists($path_to_schedule);
                    };
                })($this),
                $path_to_schedule
            );

        $AppTester
            ->given(Utils\PdfAssignmentFormWriter::class, $assignment_form_writer_config)
            ->when(
                __NAMESPACE__ . "\Functions\writeMonthOfAssignmentForms",
                Utils\PdfAssignmentFormWriter::class,
                $ListOfContacts,
                $this->assignments()
            )
            ->then(
                (function (self $test) use ($assignment_form_filenames) {
                    return function (string $path_to_forms) use ($test, $assignment_form_filenames) {
                        $assertFormsExist = function (string $filename_of_form) use (
                            $test,
                            $path_to_forms,
                            $assignment_form_filenames
                        ) {
                            $test->assertFileExists(
                                $form_filename = buildPath(
                                    $path_to_forms,
                                    $filename_of_form
                                )
                            );
                            $assignment_form_filenames->add($form_filename);
                        };
                        $forms = new \Ds\Vector(array_diff(scandir($path_to_forms), [".", "..", "DS_Store"]));
                        $forms->apply($assertFormsExist);
                    };
                })($this),
                $path_to_forms
            );

        $MailSender = (new Utils\MailSender(...$mail_sender_args))->withMailer($Mailer);

        $AppTester
            ->given(Utils\MailSender::class, ...$mail_sender_args)
            ->with([$MailSender, "withMailer"], $Mailer)
            ->when(
                __NAMESPACE__ . "\Functions\sendAssignmentForms",
                Utils\MailSender::class,
                Functions\filenamesMappedToTheirRecipient(
                    $assignment_form_filenames,
                    $ListOfContacts
                ),
                Functions\Logging\nullLogger(),
                true
            )
            ->then(
                (function (self $test) use ($ListOfContacts) {
                    return function () use ($test, $ListOfContacts) {
                        (new \Ds\Vector([
                            $ListOfContacts->findByFullname(
                                new Fullname("Thelonious", "Monk")
                            ),
                            $ListOfContacts->findByFullname(
                                new Fullname("Art", "Tatum")
                            ),
                            $ListOfContacts->findByFullname(
                                new Fullname("Bob", "Smith")
                            )
                        ]))->apply(
                            function (Contact $contact_to_verify) use ($test): void {
                                $test->assertStringContainsString(
                                    "Dear {$contact_to_verify->firstName()}",
                                    Result::MailInbox()
                                );
                                $test->assertStringContainsString(
                                    "Thanks!",
                                    Result::MailInbox()
                                );
                                $test->assertStringContainsString(
                                    (string) $contact_to_verify->guid(),
                                    Result::MailInbox()
                                );
                            }
                        );
                    };
                })($this)
            );
    }

    protected function assignments(): array
    {
        return [
            [
                "4" => [
                    "date" => "January 10",
                    "assignment" => "Bible Reading",
                    "name" => "Bob Smith",
                    "assistant" => "",
                    "counsel_point" => ""
                ],
                "5" => [
                    "date" => "January 10",
                    "assignment" => "Talk",
                    "name" => "Thelonious Monk",
                    "assistant" => "",
                    "counsel_point" => ""
                ]
            ],
            [
                "4" => [
                    "date" => "January 17",
                    "assignment" => "Bible Reading",
                    "name" => "Bob Smith",
                    "assistant" => "",
                    "counsel_point" => ""
                ],
                "5" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Thelonious Monk",
                    "assistant" => "Art Tatum",
                    "counsel_point" => ""
                ],
                "6" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Art Tatum",
                    "assistant" => "Oscar Peterson",
                    "counsel_point" => ""
                ],
                "7" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Thelonious Monk",
                    "assistant" => "Art Tatum",
                    "counsel_point" => ""
                ]
            ],
            [
                "4" => [
                    "date" => "January 17",
                    "assignment" => "Bible Reading",
                    "name" => "Bob Smith",
                    "assistant" => "",
                    "counsel_point" => ""
                ],
                "5" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Thelonious Monk",
                    "assistant" => "Art Tatum",
                    "counsel_point" => ""
                ],
                "6" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Art Tatum",
                    "assistant" => "Oscar Peterson",
                    "counsel_point" => ""
                ],
                "7" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Thelonious Monk",
                    "assistant" => "Art Tatum",
                    "counsel_point" => ""
                ]
            ],
            [
                "4" => [
                    "date" => "January 17",
                    "assignment" => "Bible Reading",
                    "name" => "Bob Smith",
                    "assistant" => "",
                    "counsel_point" => ""
                ],
                "5" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Thelonious Monk",
                    "assistant" => "Art Tatum",
                    "counsel_point" => ""
                ],
                "6" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Art Tatum",
                    "assistant" => "Oscar Peterson",
                    "counsel_point" => ""
                ],
                "7" => [
                    "date" => "January 17",
                    "assignment" => "Initial Call",
                    "name" => "Thelonious Monk",
                    "assistant" => "Art Tatum",
                    "counsel_point" => ""
                ]
            ]
        ];
    }

    protected function schedule(): array
    {
        return Functions\weeksFrom(json_decode(
            \file_get_contents(
                Functions\buildPath(
                    __DIR__,
                    "..",
                    "mocks",
                    "months",
                    "January.json"
                )
            ),
            true
        ));
    }

    protected function teardown(): void
    {
        file_exists($this->path_to_created_assignment_forms)
            && rmdir($this->path_to_created_assignment_forms);

        file_exists($this->path_to_created_schedule)
            && unlink($this->path_to_created_schedule);
    }
}
