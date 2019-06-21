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

use \Ds\Stack;

function rollback(Stack $undo_actions): void
{
    while (!$undo_actions->isEmpty()) {
        $current_undo = $undo_actions->pop();
        $current_undo();
    }
}
