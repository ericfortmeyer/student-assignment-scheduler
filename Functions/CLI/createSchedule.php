<?php

namespace TalkSlipSender\Functions\CLI;

function createSchedule(array $schedule_for_week, string $month)
{
    $date = "$month {$schedule_for_week["date"]}";
    echo blue("Schedule for ${date}\r\n");
    return array_merge(
        [createBibleReading($date)],
        array_map(
            function (string $assignment) use ($date) {
                echo heading($assignment);
                return createAssignment(
                    $date,
                    $assignment,
                    readline("Enter student's name: "),
                    readline("Enter counsel point: "),
                    $assignment !== "Talk" ? readline("Enter assistant's name: ") : ""
                );
            },
            array_filter(
                $schedule_for_week,
                function (string $data, string $key) {
                    return $key !== "date" && doesNotHaveWordVideo($data);
                },
                ARRAY_FILTER_USE_BOTH
            )
        )
    );
}
