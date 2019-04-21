<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\{
    save,
    importMultipleSchedules,
    removeSpecialEventsFromSchedule,
    assignmentDateField,
    Filenaming\jsonAssignmentFilename
};

use StudentAssignmentScheduler\Classes\{
    Date,
    Destination,
    ListOfContacts,
    MonthOfAssignments,
    WeekOfAssignments,
    SpecialEventHistory
};

use StudentAssignmentScheduler\Rules\{
    JsonAssignmentFilenamePolicy,
    AssignmentMonthFieldPolicy
};

use \DateTimeImmutable;

/**
 * Interact with the user of the application to schedule assignments
 *
 * A json file is created for each week of assignments
 */
function createJsonAssignments(
    Destination $path_to_json_schedules,
    string $data_destination,
    \Closure $hasScheduleAlreadyBeenCompleted,
    ListOfContacts $ListOfContacts,
    SpecialEventHistory $SpecialEventHistory
): bool {
    
    $were_assignments_made = false;

    $sortMonths = function (MonthOfAssignments $a, MonthOfAssignments $b): int {
        return $a->month() <=> $b->month();
    };

    $removeSpecialEventsFromSchedule = function (
        MonthOfAssignments $assignments
    ) use ($SpecialEventHistory): MonthOfAssignments {
        return removeSpecialEventsFromSchedule(
            $SpecialEventHistory,
            $assignments
        );
    };

    $interactWithUserToCreateAssignments = function (
        MonthOfAssignments $MonthOfAssignments
    ) use (
        $data_destination,
        $hasScheduleAlreadyBeenCompleted,
        $ListOfContacts,
        &$were_assignments_made
    ) {
            $month = $MonthOfAssignments->month();
            $year = $MonthOfAssignments->year();

            !file_exists($data_destination) && mkdir($data_destination, 0700);

            $isPastMonth = new DateTimeImmutable("${year}-${month}") < new DateTimeImmutable("00:00");

            // do the assignments need to be created?
            $shouldAbort = $isPastMonth || $MonthOfAssignments->weeks()->count() > 1;
            $skipCreatingAssignments = $MonthOfAssignments->weeks()->count() > 1
                && !$hasScheduleAlreadyBeenCompleted($month);
            
        if ($shouldAbort || $skipCreatingAssignments) {
            // important to set this
            $were_assignments_made = $shouldAbort ? false : true;
            return;
        }

            $reply = readline(
                readyForSchedulePrompt($month)
            );

        do {
            if (yes($reply)) {
                echo creatingScheduleMessage($month);
                $MonthOfAssignments->weeks()->map(
                    function (
                        Date $date,
                        WeekOfAssignments $WeekOfAssignments
                    ) use (
                        $data_destination,
                        $ListOfContacts,
                        $MonthOfAssignments
                    ) {

                        $filename = jsonAssignmentFilename(
                            new Destination($data_destination),
                            $date,
                            new JsonAssignmentFilenamePolicy(
                                $MonthOfAssignments,
                                $date
                            )
                        );

                        userDecidesToAbortOrRedoIfScheduleExists($filename, $date);
                            
                        save(
                            userCreatesWeekOfAssignments(
                                $WeekOfAssignments,
                                assignmentDateField(
                                    $date->dayOfMonth(),
                                    new AssignmentMonthFieldPolicy(
                                        $MonthOfAssignments,
                                        $date
                                    )
                                ),
                                $MonthOfAssignments->year(),
                                $ListOfContacts
                            ),
                            $filename,
                            true
                        );
                    }
                );

                $were_assignments_made = true;
            } elseif (no($reply)) {
                echo "ok\r\n";

                $were_assignments_made =  false;
            } else {
                echo "Please enter yes or no\r\n";
                $reply = readline(
                    readyForSchedulePrompt($month)
                );
            }
        } while (notYesOrNo($reply));
    };
    
    importMultipleSchedules($path_to_json_schedules)
        ->sorted($sortMonths)
        ->map($removeSpecialEventsFromSchedule)
        ->map($interactWithUserToCreateAssignments);

    return $were_assignments_made;
}

function userDecidesToAbortOrRedoIfScheduleExists(
    string $filename_of_schedule,
    Date $date
): void {
    if (file_exists($filename_of_schedule)) {
        echo green(
            "It looks like the schedule for {$date->asText()} is already complete." . PHP_EOL
        );
        $redo = readline(
            prompt("Would you like to redo this week")
        );

        do {
            if (no($redo)) {
                echo "ok\r\n";
                return;
            } elseif (yes($redo)) {
                echo red("Redoing schedule for {$date->asText()}" . PHP_EOL);
            } else {
                echo "Please enter yes or no" . PHP_EOL;
                $redo = readline(prompt("Redo"));
            }
        } while (notYesOrNo($redo));
    }
}
