<?php

namespace TalkSlipSender\Functions;

function filenamesInDirectory(
    string $dir,
    string $error_msg = "",
    bool $exit_program = false
) {
    $result = array_diff(
        scandir($dir),
        [".", "..", ".DS_Store"]
    );

    if ($result) {
        return $result;
    } else {
        $exit_program ? abort($error_msg) : print($error_msg);        
    }
}

function abort(string $error_msg): void
{
    exit($error_msg);
}
