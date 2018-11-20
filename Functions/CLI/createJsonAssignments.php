<?php

namespace TalkSlipSender\Functions\CLI;

use function TalkSlipSender\Functions\save;
use function TalkSlipSender\Functions\monthNumeric;
use function TalkSlipSender\Functions\weeksFrom;
use function TalkSlipSender\Functions\importMultipleSchedules;
use function TalkSlipSender\Functions\sortMonths;
use function TalkSlipSender\Functions\isPastMonth;

function createJsonAssignments(
    string $path_to_json_schedules,
    string $data_destination
) {
    array_map(
        function (array $schedule_for_month) use ($data_destination) {

            $month = $schedule_for_month["month"];
            $year = $schedule_for_month["year"];

            if (isPastMonth($month)) {
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

                            if (file_exists(
                                "${data_destination}/"
                                        . monthNumeric($month)
                                        . "{$schedule_for_week["date"]}.json"
                            )
                            ) {
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

                            $schedule_dest = $data_destination;
                
                            save(
                                $schedule,
                                $schedule_dest,
                                monthNumeric($month) . "{$schedule_for_week["date"]}"
                            );
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
