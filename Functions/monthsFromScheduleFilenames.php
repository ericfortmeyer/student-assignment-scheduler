<?php

namespace TalkSlipSender\Functions;

function monthsFromScheduleFilenames(string $path_to_json_schedules): array
{
    return array_map(
        function (array $arr): string {
            return isPastMonth($arr["month"]) ? "" : "{$arr["month"]}";
        },
        sortMonths(
            array_map(
                function (string $filename) {
                    /**
                     * Requires key "month" to simplify passing arguments into
                     * sortMonths function for other clients
                     */
                    $result["month"] = str_replace(".json", "", $filename);
                    return $result;
                },
                array_diff(
                    scandir($path_to_json_schedules),
                    [".", "..", ".DS_Store"]
                )
            )
        )
    );
}
