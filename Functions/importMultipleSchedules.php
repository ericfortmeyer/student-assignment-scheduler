<?php

namespace TalkSlipSender\Functions;


use function TalkSlipSender\Functions\CLI\white;

function importMultipleSchedules(string $path_to_json_schedules): array
{
    return array_map(
        function (string $json_file) use ($path_to_json_schedules) {
            return importJson("$path_to_json_schedules/$json_file");
        },
        filenamesInDirectory(
            $path_to_json_schedules,
            white("Nothing was scheduled.  Bye\r\n"),
            true
        )
    );
}
