<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

use StudentAssignmentScheduler\{
    ListOfContacts,
    Fullname,
    ListOfScheduleRecipients,
    Notification\MailSender,
    DocumentProduction\AssignmentFormWriterInterface
};
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;
use function StudentAssignmentScheduler\Notification\Functions\{
    filenamesMappedToTheirRecipient,
    sendAssignmentForms,
    sendSchedule
};
use function StudentAssignmentScheduler\Filenaming\Functions\assignmentFormFilename;
use function StudentAssignmentScheduler\DocumentProduction\Functions\{
    writeMonthOfAssignmentForms,
    writeAssignmentFormFromAssignment
};
use function StudentAssignmentScheduler\Querying\Functions\{
    monthOfAssignments
};
use function StudentAssignmentScheduler\Logging\Functions\emailLogger;
use \Ds\{
    Map,
    Set,
    Vector
};

function commandMap(): Map
{
    return new Map(
        [
            "assignments" => function (
                MailSender $MailSender,
                ListOfContacts $ListOfContacts,
                array $config,
                ListOfScheduleRecipients $ListOfScheduleRecipients,
                AssignmentFormWriterInterface $AssignmentFormWriter
            ): void {
                $assignment_forms_destination = $config["assignment_forms_destination"];
                $option = userSelectsMonthOrSingleAssignmentOption();
                $assignmentOptionMap = new Map([
                    "month of assignments" => function (
                        MailSender $MailSender,
                        ListOfContacts $ListOfContacts,
                        AssignmentFormWriterInterface $AssignmentFormWriter,
                        string $assignment_forms_destination
                    ): void {
                        $selectedMonth = userSelectsMonth();
                        writeMonthOfAssignmentForms(
                            $AssignmentFormWriter,
                            $ListOfContacts,
                            monthOfAssignments($selectedMonth)($assignment_forms_destination)
                        );
                    },
                    "single assignment" => function (
                        MailSender $MailSender,
                        ListOfContacts $ListOfContacts,
                        AssignmentFormWriterInterface $AssignmentFormWriter,
                        string $assignment_forms_destination
                    ): void {
                        [
                            $assignment_number,
                            $selectedAssignment
                        ] = userSelectsAssignment();
                        
                        writeAssignmentFormFromAssignment(
                            $AssignmentFormWriter,
                            $assignment_number,
                            $selectedAssignment,
                            assignmentFormFilename(
                                new Fullname($selectedAssignment["name"]),
                                $ListOfContacts
                            )
                        );
                    }
                ]);
                $orHandleInvalidSelection = function () use ($option, $assignmentOptionMap) {
                    print "Invalid selection.  Please try again.";
                    $handleInvalidSelection = function () use ($option, $assignmentOptionMap) {
                        $assignmentOptionMap->get($option, $assignmentOptionMap);
                    };
                };
                $writeAssignmentsFunc = $assignmentOptionMap->get($option, $orHandleInvalidSelection);
                $writeAssignmentsFunc(
                    $MailSender,
                    $ListOfContacts,
                    $AssignmentFormWriter,
                    $assignment_forms_destination
                );
                $appendDirectoryToFilename = function (
                    string $basename
                ) use ($assignment_forms_destination): string {
                    return buildPath($assignment_forms_destination, $basename);
                };

                $attachment_filenames = new Set(
                    (new Vector(filenamesInDirectory($assignment_forms_destination)))
                        ->map($appendDirectoryToFilename)
                );
                sendAssignmentForms(
                    $MailSender,
                    filenamesMappedToTheirRecipient(
                        $attachment_filenames,
                        $ListOfContacts
                    ),
                    emailLogger("sendAssignmentForms")
                );
            },
            "schedule" => function (
                MailSender $MailSender,
                ListOfContacts $ListOfContacts,
                array $config,
                ListOfScheduleRecipients $ListOfScheduleRecipients
            ): void {
                $directory_of_schedule = $config["schedules_destination"];
                $filenameOfScheduleSelected = userSelectsSchedule();
                $schedule_filename = buildPath($directory_of_schedule, $filenameOfScheduleSelected);
                sendSchedule(
                    $MailSender,
                    $ListOfContacts,
                    $ListOfScheduleRecipients,
                    $schedule_filename,
                    emailLogger("sendSchedule")
                );
            },
            "man" => function (): void {
                showManPage();
            },
            "help" => function (): void {
                showManPage();
            }
        ]
    );
}

function handleInvalidSelection($option, Map $assignmentOptionMap)
{
    print "Invalid selection.  Please try again.";
    $orHandleInvalidSelection = function () use ($option, $assignmentOptionMap) {
        handleInvalidSelection($option, $assignmentOptionMap);
    };
    return $assignmentOptionMap->get($option, $orHandleInvalidSelection);
}
