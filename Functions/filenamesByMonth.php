<?php

namespace TalkSlipSender\Functions;

/**
 * @param string $month
 * @param string $path_to_files
 * @return string[]
 */
function filenamesByMonth(string $month, string $path_to_files): array
{
    return array_filter(
        array_diff(
            scandir($path_to_files),
            [".", "..", "DS_Store"]
        ),
        function (string $file) use ($month) {
            return str_split($file, 2)[0] === monthNumeric($month);
        }
    );
}
