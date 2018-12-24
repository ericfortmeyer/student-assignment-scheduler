<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\save;
use function StudentAssignmentScheduler\Functions\monthNumeric;
use function StudentAssignmentScheduler\Functions\weeksFrom;
use function StudentAssignmentScheduler\Functions\importMultipleSchedules;
use function StudentAssignmentScheduler\Functions\sortMonths;
use function StudentAssignmentScheduler\Functions\isPastMonth;

/**
 * Interact with the user of the application to schedule assignments
 *
 * A json file is created for each week of assignments
 */
function createJsonAssignments(
    string $path_to_json_schedules,
    string $data_destination,
    \Closure $hasScheduleAlreadyBeenCompleted
) {
    array_map(
        function (array $schedule_for_month) use ($data_destination, $hasScheduleAlreadyBeenCompleted) {

            $month = $schedule_for_month["month"];
            $year = $schedule_for_month["year"];

            $shouldAbort = isPastMonth($month, $year) || $hasScheduleAlreadyBeenCompleted($month);

            if ($shouldAbort) {
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
                            $data_destination
                        ) {

                            $filename = "${data_destination}/"
                                . monthNumeric($month)
                                . "{$schedule_for_week["date"]}.json";


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
                } elseif (no($reply)) {
                    echo "ok\r\n";
                    return;
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
}
