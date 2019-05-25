<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use \Ds\Stack;

function rollback(Stack $undo_actions): void
{
    while (!$undo_actions->isEmpty()) {
        $current_undo = $undo_actions->pop();
        $current_undo();
    }
}
