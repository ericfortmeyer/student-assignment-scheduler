<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\save;
use function StudentAssignmentScheduler\Functions\weeksFrom;
use function StudentAssignmentScheduler\Functions\importAssignments;
use function StudentAssignmentScheduler\Functions\importMultipleSchedules;
use function StudentAssignmentScheduler\Functions\sortMonths;
use function StudentAssignmentScheduler\Functions\isPastMonth;
use function StudentAssignmentScheduler\Functions\assignmentDateField;
use function StudentAssignmentScheduler\Functions\Filenaming\jsonAssignmentFilename;

use StudentAssignmentScheduler\Classes\Destination;
use StudentAssignmentScheduler\Classes\Month;
use StudentAssignmentScheduler\Classes\DayOfMonth;

use StudentAssignmentScheduler\Rules\JsonAssignmentFilenamePolicy;
use StudentAssignmentScheduler\Rules\JsonAssignmentFilenamePolicy as Key;
use StudentAssignmentScheduler\Rules\AssignmentMonthFieldPolicy;
use StudentAssignmentScheduler\Rules\AssignmentMonthFieldPolicy as Key2;
use StudentAssignmentScheduler\Rules\Context;

/**
 * Interact with the user of the application to schedule assignments
 *
 * A json file is created for each week of assignments
 */
function createJsonAssignments(
    string $path_to_json_schedules,
    string $data_destination,
    \Closure $hasScheduleAlreadyBeenCompleted
): bool {
    
    $were_assignments_made = false;

    array_map(
        function (array $schedule_for_month) use (
            $data_destination,
            $hasScheduleAlreadyBeenCompleted,
            &$were_assignments_made
        ) {

            $month = $schedule_for_month["month"];
            $year = $schedule_for_month["year"];

            $haveAssignmentsAlreadyBeenCreated = function (string $month) use ($year, $data_destination): bool {
                $weeksOfAssignments = importAssignments($month, $data_destination);

                // we could test for a higher count here
                return count($weeksOfAssignments) > 1;
            };


            // do the assignments need to be created?
            $shouldAbort = isPastMonth($month, $year) || $hasScheduleAlreadyBeenCompleted($month);
            $skipCreatingAssignments = $haveAssignmentsAlreadyBeenCreated($month)
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
                    array_map(
                        function (
                            array $schedule_for_week,
                            string $key
                        ) use (
                            $month,
                            $year,
                            $data_destination,
                            $schedule_for_month
                        ) {

                            $filename = jsonAssignmentFilename(
                                new Destination($data_destination),
                                new Month($month),
                                new DayOfMonth($schedule_for_week["date"]),
                                new JsonAssignmentFilenamePolicy(
                                    new Context([
                                        Key::SCHEDULE_FOR_MONTH => $schedule_for_month,
                                        Key::MONTH => new Month($month),
                                        Key::DAY_OF_MONTH => new DayOfMonth($schedule_for_week["date"])
                                    ])
                                )
                            );

                            userDecidesToAbortOrRedoIfScheduleExists(
                                $filename,
                                $month,
                                $schedule_for_week["date"]
                            );
                            
                            save(
                                userCreatesWeekOfAssignments(
                                    $schedule_for_week,
                                    assignmentDateField(
                                        new DayOfMonth($schedule_for_week["date"]),
                                        new AssignmentMonthFieldPolicy(
                                            new Context([
                                                Key2::SCHEDULE_FOR_MONTH => $schedule_for_month,
                                                Key2::MONTH => new Month($month),
                                                Key2::DAY_OF_MONTH => new DayOfMonth($schedule_for_week["date"])
                                            ])
                                        )
                                    ),
                                    $year
                                ),
                                $filename,
                                true
                            );
                        },
                        weeksFrom($schedule_for_month),
                        array_keys(weeksFrom($schedule_for_month))
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
        },
        sortMonths(
            importMultipleSchedules($path_to_json_schedules)
        )
    );
    return $were_assignments_made;
}

function userDecidesToAbortOrRedoIfScheduleExists(
    string $filename_of_schedule,
    string $month,
    string $day_of_month
): void {
    if (file_exists($filename_of_schedule)) {
        echo green(
            "It looks like the schedule for ${month} ${day_of_month} is already complete." . PHP_EOL
        );
        $redo = readline(
            prompt("Would you like to redo this week")
        );

        do {
            if (no($redo)) {
                echo "ok\r\n";
                return;
            } elseif (yes($redo)) {
                echo red("Redoing schedule for ${month}"
                    . " ${day_of_month}\r\n");
            } else {
                echo "Please enter yes or no\r\n";
                $redo = readline(prompt("Redo"));
            }
        } while (notYesOrNo($redo));
    }
}
