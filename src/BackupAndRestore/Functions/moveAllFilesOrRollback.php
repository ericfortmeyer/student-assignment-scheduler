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
