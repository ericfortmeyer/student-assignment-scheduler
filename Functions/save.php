<?php

namespace TalkSlipSender\Functions;

/**
 * @param mixed[] $info
 * @param string $path_to_data
 * @return mixed int|bool number of bytes written or false on failure
 */
function save(array $info, string $path_to_data, string $filename)
{
    !file_exists("$path_to_data/{$info["year"]}")
        && mkdir("$path_to_data/{$info["year"]}", 0777, true);

    return file_put_contents(
        "$path_to_data/{$info["year"]}/${filename}.json",
        json_encode($info, JSON_PRETTY_PRINT)
    );
}
