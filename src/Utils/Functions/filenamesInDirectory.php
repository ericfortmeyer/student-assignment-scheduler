<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

/**
 * Returns the filenames in a given directory.
 *
 * @param string $dir
 * @param string $error_msg
 * @param bool $should_exit
 * @param array $exclude Files to exclude
 * @return string[]|void
 */
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
