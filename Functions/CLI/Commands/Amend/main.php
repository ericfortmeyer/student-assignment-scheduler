<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Amend;

use \DateTimeImmutable;

use StudentAssignmentScheduler\Classes\{
    Month,
    Destination,
    ListOfContacts,
    Fullname
};
use StudentAssignmentScheduler\Utils\{
    AssignmentFormWriterInterface,
    ScheduleWriterInterface,
    MailSender
};

use function StudentAssignmentScheduler\Functions\{
    writeAssignmentFormFromAssignment,
    importAssignments,
    importSchedule,
    sendEmails,
    copyAndSwapJsonAssignment,
    removeYearKey,
    redoSchedule,
    dayOfMonthFromAssignmentDate,
    CLI\createAssignment,
    CLI\userAssignsAssistant,
    CLI\retryUntilFullnameIsValid
};

function main(
    Month $month,
    ListOfContacts $ListOfContacts,
    AssignmentFormWriterInterface $AssignmentFormWriter,
    ScheduleWriterInterface $ScheduleWriter,
    MailSender $MailSender,
    string $path_to_json_assignments,
    string $path_to_json_schedules,
    string $path_to_assignment_forms,
    string $path_to_schedules,
    array $schedule_recipients
): void {
    $month_of_assignments = importAssignments($month->asText(), $path_to_json_assignments);
    $original_assignments = removeYearKey($month_of_assignments);

    $userSelectedAssignmentKeyValuePair = userSelectsAssignment($original_assignments);
    $userSelectedAssignment = current($userSelectedAssignmentKeyValuePair);
    $assignment_number = key($userSelectedAssignmentKeyValuePair);


    $userSelectedWeek = (function (array $month_of_assignments, array $userSelectedAssignment) {

        $weekContaingSelection = function ($week_of_assignments) use ($userSelectedAssignment) {
            return in_array($userSelectedAssignment, $week_of_assignments);
        };
        
        return (new \Ds\Vector($month_of_assignments))
            ->filter($weekContaingSelection)
            ->toArray()[0];
    })($original_assignments, $userSelectedAssignment);


    $newAssignment = [
        $assignment_number => createAssignment(
            $ListOfContacts,
            $userSelectedAssignment["date"],
            $userSelectedAssignment["assignment"],
            retryUntilFullnameIsValid(
                new Fullname(
                    readline("Enter student's name: ")
                ),
                $ListOfContacts
            ),
            userAssignsAssistant(
                $userSelectedAssignment["assignment"],
                $ListOfContacts
            )
        )
    ];

    $schedule_for_month = importSchedule($month->asText() . ".json", $path_to_json_schedules);

    copyAndSwapJsonAssignment(
        $userSelectedAssignment,
        $newAssignment,
        $userSelectedWeek,
        $schedule_for_month,
        $month,
        dayOfMonthFromAssignmentDate($userSelectedAssignment["date"]),
        new Destination($path_to_json_assignments),
        new DateTimeImmutable()
    );

    writeAssignmentFormFromAssignment(
        $AssignmentFormWriter,
        $assignment_number,
        $newAssignment[$assignment_number]
    );

    $scheduleFilename = redoSchedule(
        $ScheduleWriter,
        $month,
        $schedule_for_month,
        $path_to_schedules,
        $path_to_json_assignments
    );

    sendEmails(
        $MailSender,
        $ListOfContacts,
        $path_to_assignment_forms,
        $schedule_recipients,
        $scheduleFilename
    );
}
