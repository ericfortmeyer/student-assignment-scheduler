<?php

$function_dir = __DIR__ . "/functions";

array_map(
    function (string $function_filename) use ($function_dir) {
        require "${function_dir}/${function_filename}";
    },
    array_diff(scandir($function_dir), [".", "..", ".DS_Store"])
);
