<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use function StudentAssignmentScheduler\CLI\{
    displayList,
    green
};

/**
 * @param string $action What the user is doing with the item selected
 * @param iterable $list
 * @return string UserInput
 */
function userSelects(string $action, iterable $list): string
{
    print PHP_EOL . PHP_EOL;
    print "Which event are you ${action}?" . PHP_EOL;
    print "Please enter the " . green("number") . " next to the event: " . PHP_EOL . PHP_EOL;
    
    displayList($list);
    return readline("..................?  ");
}
