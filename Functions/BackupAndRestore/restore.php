<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use StudentAssignmentScheduler\Classes\{
    RestoreConfig,
    File,
    Directory
};

use function StudentAssignmentScheduler\Functions\{
    buildPath,
    hashOfFile
};

use function StudentAssignmentScheduler\FileRegistry\Functions\registerFile;

use \ZipArchive;

use \Ds\{
    Map,
    Queue,
    Stack
};

function restore(RestoreConfig $config): bool
{
    $config->extractToTmpDir(new ZipArchive());
    $file_moving_queue = new Queue();
    mapOfOldNamesToNewNames($config)->apply(
        function (string $oldname, string $newname) use ($file_moving_queue) {
            $file_moving_queue->push(
                (function (string $oldname, string $newname): \Closure {
                    return function () use ($oldname, $newname) {
                        $target_directory = dirname($newname);
                        !\file_exists($target_directory) && mkdir($target_directory);
                        $moveFile = function (string $oldname, string $newname) {
                            // do this first
                            $wasMovingTheFileSuccessful = rename($oldname, $newname);
                            // do this second
                            registerFile(hashOfFile($newname), $newname);
                            return $wasMovingTheFileSuccessful;
                        };
                        $putOriginalFileBack = file_exists($newname)
                            ? (function(string $original_filename) {
                                $original_file_contents = \file_get_contents($original_filename);
                                return function () use ($original_filename, $original_file_contents) {
                                    file_put_contents($original_filename, $original_file_contents);
                                };
                            })($newname)
                            : function () {
                                //no op
                            };
                        $file_that_was_moved = $newname;
                        return $moveFile($oldname, $newname)
                            ? function () use ($file_that_was_moved, $putOriginalFileBack) {
                                unlink($file_that_was_moved);
                                $putOriginalFileBack();
                            }
                            : false;
                    };
                })((string) $oldname, $newname)
            );
        }
    );

    return moveAllFilesOrRollback($file_moving_queue, $config);
}

function moveAllFilesOrRollback(Queue $file_moving_queue, RestoreConfig $config): bool
{
    $undo_actions = new Stack();

    while (!$file_moving_queue->isEmpty()) {
        $current_move = $file_moving_queue->pop();
        $undoOrFalse = $current_move();
        if ($undoOrFalse !== false) {
            $undo = $undoOrFalse;
            $undo_actions->push($undo);
        } else {
            rollback($undo_actions);
            return false;
        }
    }

    $config->removeTmpDir();
    return true;
}

function rollback(Stack $undo_actions): void
{
    while (!$undo_actions->isEmpty()) {
        $current_undo = $undo_actions->pop();
        $current_undo();
    }
}

function mapOfOldNamesToNewNames(RestoreConfig $config): Map
{
    $map = new Map();

    $config->filesInTmpDir()->reduce(
        function ($carry, string $oldname) use ($map, $config) {
            $file = new File($oldname);
            $newname = $config->newNameFromOldName($file);
            recursivelyAddTargetFilenamesToMap(
                $map,
                $config,
                (string) $file,
                $newname
            );
        }
    );

    return $map;
}
function recursivelyAddTargetFilenamesToMap(Map $map, RestoreConfig $config, string $oldname, string $newname)
{
    is_dir($oldname)
        ? (new Directory($oldname))->files()->reduce(
            function ($carry, string $name_of_file_in_dir) use ($map, $config, $oldname, $newname) {
                $current_directory = $oldname;
                $target_directory = $newname;
                $basename_of_file = basename($name_of_file_in_dir);
                $original_filename = buildPath($current_directory, $basename_of_file);
                $target_filename = buildPath($target_directory, $basename_of_file);
                recursivelyAddTargetFilenamesToMap($map, $config, $original_filename, $target_filename);
            }
        )
        : $map->put($oldname, $newname);

}

