<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

use function StudentAssignmentScheduler\{
    Encryption\Functions\hashOfFile,
    Encryption\Functions\registerFile
};
use \Ds\Queue;

function moveFile(string $oldname, string $newname): bool
{
    $file_moving_tasks = new Queue();
    $file_moving_tasks->push(
        (function (string $oldname, string $newname): \Closure {
            return function () use ($oldname, $newname): bool {
                return rename($oldname, $newname);
            };
        })($oldname, $newname)
    );
    $file_moving_tasks->push(
        (function (string $oldname, $newname): \Closure {
            return function () use ($oldname, $newname): void {
                if (basename($oldname) === ".env") {
                    // search for the path to secrets
                    // in the env file
                    $contents_of_env_file = file_get_contents($newname);
                    $string_to_split = Functions\buildPath("data", "secrets") . DIRECTORY_SEPARATOR;
                    $splitString = explode(
                        $string_to_split,
                        $contents_of_env_file
                    );
                    $lines = explode(
                        PHP_EOL,
                        rtrim(current($splitString), DIRECTORY_SEPARATOR)
                    );
                    $key_value_pair = end($lines);
                    $filename = end($splitString);
                    [$blank, $fullpath] = explode(
                        $key_value_pair,
                        file_get_contents($newname)
                    );
                    [$key, $prepend_directory] = explode(
                        "=",
                        $key_value_pair
                    );
                    $path_to_search = Functions\buildPath(
                        $prepend_directory,
                        "data",
                        "secrets"
                    );
                    $replace_with = realpath(
                        Functions\buildPath(
                            __DIR__,
                            "..",
                            "..",
                            "..",
                            "data",
                            "secrets"
                        )
                    );
                    changePathsInEnvFile(
                        $newname,
                        $path_to_search,
                        $replace_with
                    );
                }
            };
        })($oldname, $newname)
    );
    $file_moving_tasks->push(
        (function (string $newname): \Closure {
            return function () use ($newname): void {
                registerFile(hashOfFile($newname), $newname);
            };
        })($newname)
    );
    $firstTask = $file_moving_tasks->pop();
    $wasMovingTheFileSuccessful = $firstTask();
    while (!$file_moving_tasks->isEmpty()) {
        $task = $file_moving_tasks->pop();
        $task();
    }
    return $wasMovingTheFileSuccessful;
}
