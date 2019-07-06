<?php

use \Ds\Vector;

$functions_dir = __DIR__ . "/functions";
$files = array_diff(scandir($functions_dir), [".", "..", "DS_Store"]);
(new Vector($files))->map(
    function (string $filename) use ($functions_dir) {
        require $functions_dir . DIRECTORY_SEPARATOR . $filename;
    }
);
