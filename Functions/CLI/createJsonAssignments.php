<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\{
    save,
    weeksFrom,
    importAssignments,
    importMultipleSchedules,
    sortMonths,
    isPastMonth,
    Filenaming\jsonAssignmentFilename
};

use StudentAssignmentScheduler\Classes\{
    Destination,
    Month,
    DayOfMonth
};

use StudentAssignmentScheduler\Rules\{
    JsonAssignmentFilenamePolicy,
    JsonAssignmentFilenamePolicy as Key,
    Context
};


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


                            if (file_exists($filename)) {
                                echo green("It looks like you've already completed "
                                    . "the schedule for ${month} "
                                    . "{$schedule_for_week["date"]}.\r\n");
                                $redo = readline(
                                    prompt("Would you like to redo this week")
                                );

                                do {
                                    if (no($redo)) {
                                        echo "ok\r\n";
                                        return;
                                    } elseif (yes($redo)) {
                                        echo red("Redoing schedule for ${month}"
                                            . " {$schedule_for_week["date"]}\r\n");
                                    } else {
                                        echo "Please enter yes or no\r\n";
                                        $redo = readline(prompt("Redo"));
                                    }
                                } while (notYesOrNo($redo));
                            }
                            
                            $schedule = createSchedule(
                                $schedule_for_week,
                                shouldUseNextMonth($key, $schedule_for_week["date"])
                                    ? nextMonth($month)
                                    : $month
                            );

                            $schedule["year"] = $year;
                
                            save($schedule, $filename, true);
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
