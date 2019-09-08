<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

function filenamesInDirectory(
    string $dir,
    string $error_msg = "",
    bool $should_exit = false,
    array $exclude = [".", "..", ".DS_Store"]
) {
    return ($result = array_diff(scandir($dir), $exclude))
        ? $result
        : handleError($should_exit, $error_msg);
}

/**
 * @codeCoverageIgnore
 */
function handleError(bool $should_exit, string $error_msg): void
{
    $should_exit ? abort($error_msg) : print($error_msg);
}

/**
 * @codeCoverageIgnore
 */
function abort(string $error_msg): void
{
    exit($error_msg);
}
