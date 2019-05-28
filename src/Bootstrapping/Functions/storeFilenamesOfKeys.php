<?php

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

function storeFilenamesOfKeys(array $filenames, string $path_to_env): void
{
    array_map(
        function (string $key, string $filename) use ($path_to_env) {
            \file_put_contents(
                $path_to_env,
                "${key}=${filename}" . PHP_EOL,
                LOCK_EX | FILE_APPEND
            );
        },
        array_keys($filenames),
        $filenames
    );
}
