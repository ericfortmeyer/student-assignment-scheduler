<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

use StudentAssignmentScheduler\{
    Date,
    Destination,
    ListOfContacts,
    MonthOfAssignments,
    WeekOfAssignments,
    SpecialEventHistory,
    Policies\JsonAssignmentFilenamePolicy,
    Policies\AssignmentMonthFieldPolicy
};
use \DateTimeImmutable;
use function StudentAssignmentScheduler\Persistence\Functions\save;
use function StudentAssignmentScheduler\Querying\Functions\{
    importMultipleSchedules,
    scheduleWithoutSpecialEvents
};
use function StudentAssignmentScheduler\Formatting\Functions\assignmentDateField;
use function StudentAssignmentScheduler\FileNaming\Functions\jsonAssignmentFilename;

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
        
        // we have to clone here since we will need to traverse
        // the stack to check each schedule for special events
        $CopyOfSpecialEventHistory = clone $SpecialEventHistory;
        
        return scheduleWithoutSpecialEvents(
            $CopyOfSpecialEventHistory,
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
            $shouldAbort = $isPastMonth || $MonthOfAssignments->weeks()->count() < 2;
            $skipCreatingAssignments = $MonthOfAssignments->weeks()->count() < 2
                && !$hasScheduleAlreadyBeenCompleted($month);
            
        if ($shouldAbort || $skipCreatingAssignments) {
            // important to set this
            $were_assignments_made = $shouldAbort ? false : true;
            return;
        }

        $reply = readline(
            readyForSchedulePrompt($month->asText())
        );

        do {
            if (yes($reply)) {
                echo creatingScheduleMessage($month->asText());
                $MonthOfAssignments->weeks()->apply(
                    function (
                        Date $date,
                        WeekOfAssignments $WeekOfAssignments
                    ) use (
                        $data_destination,
                        $ListOfContacts,
                        $MonthOfAssignments
                    ): void {

                        $filename = jsonAssignmentFilename(
                            new Destination($data_destination),
                            $date,
                            new JsonAssignmentFilenamePolicy(
                                $MonthOfAssignments,
                                $date
                            )
                        );

                        if (scheduleExistsAndUserDoesNotWantToRedo($filename, $date)) {
                            return;
                        }
                            
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
                                (string) $MonthOfAssignments->year(),
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
                    readyForSchedulePrompt((string) $month)
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

function scheduleExistsAndUserDoesNotWantToRedo(
    string $filename_of_schedule,
    Date $date
): bool {
    if (file_exists($filename_of_schedule)) {
        echo green(
            "It looks like the schedule for {$date->asText()} is already complete." . PHP_EOL
        );
        $redo = readline(
            prompt("Would you like to redo this week")
        );

        if (no($redo)) {
            echo "ok\r\n";
            return true;
        } elseif (yes($redo)) {
            echo red("Redoing schedule for {$date->asText()}" . PHP_EOL);
            return false;
        } else {
            echo "Please enter yes or no" . PHP_EOL;
            return scheduleExistsAndUserDoesNotWantToRedo($filename_of_schedule, $date);
        }
    }
    return false;
}
