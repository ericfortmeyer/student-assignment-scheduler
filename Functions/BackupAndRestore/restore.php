<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use StudentAssignmentScheduler\Classes\{
    RestoreConfig,
    File,
    Directory
};
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
                        return rename($oldname, $newname)
                            ? function () use ($oldname, $newname) {
                                rename($newname, $oldname);
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
        if ($undo_action_to_add = $current_move() !== false) {
            $undo_actions->push($undo_action_to_add);
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
    is_dir($newname)
        ? (new Directory($newname))->files()->reduce(
            function ($carry, string $filename) use ($map, $config, $oldname) {
                $file = "${oldname}/" . basename($filename);
                $rename_to = $filename;
                recursivelyAddTargetFilenamesToMap($map, $config, $file, $rename_to);
            }
        )
        : $map->put($oldname, $newname);

}

