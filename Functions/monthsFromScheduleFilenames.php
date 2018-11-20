<?php

namespace TalkSlipSender\Functions;

function monthsFromScheduleFilenames(string $path_to_json_schedules, bool $do_past_months): array
{
    return array_filter(
        sortMonths(
            array_map(
                function (string $filename) {
                    /**
                     * Requires key "month" to simplify passing arguments into
                     * sortMonths function for other clients
                     */
                    return [
                        "month" => str_replace(".json", "", $filename)
                    ];
                },
                array_diff(
                    scandir($path_to_json_schedules),
                    [".", "..", ".DS_Store"]
                )
            )
        ),
        function (array $arr) use ($do_past_months) {
            return (!$do_past_months && !isPastMonth($arr["month"]));
        }
    );
}
