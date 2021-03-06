<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

use StudentAssignmentScheduler\BackupAndRestore\RestoreConfig;
use \Ds\{
    Queue,
    Stack
};

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
