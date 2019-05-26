<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use function StudentAssignmentScheduler\Functions\{
    hashOfFile,
    getConfig,
    buildPath
};
use function StudentAssignmentScheduler\FileRegistry\Functions\registerFile;

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
                    changePathsInEnvFile(
                        $newname,
                        buildPath(
                            getConfig()["app_root_dir"],
                            "data",
                            "secrets"
                        )
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
