<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

use \Ds\Stack;

function rollback(Stack $undo_actions): void
{
    while (!$undo_actions->isEmpty()) {
        $current_undo = $undo_actions->pop();
        $current_undo();
    }
}
