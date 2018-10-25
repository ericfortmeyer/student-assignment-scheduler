<?php

namespace TalkSlipSender\Functions;

function importMultipleSchedules(string $path_to_json_schedules)
{
    return array_map(
        function (string $json_file) use ($path_to_json_schedules) {
            return importJson("$path_to_json_schedules/$json_file");
        },
        array_diff(scandir($path_to_json_schedules), [".", "..", ".DS_Store"])
    );
}
