<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use \Ds\{
    Queue,
    Stack
};
use StudentAssignmentScheduler\Classes\RestoreConfig;

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
