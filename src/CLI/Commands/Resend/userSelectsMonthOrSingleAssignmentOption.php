<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

use function StudentAssignmentScheduler\CLI\{
    red,
    displayList
};
use \Ds\Vector;

function userSelectsMonthOrSingleAssignmentOption(): string
{
    $options = new Vector([
        "month of assignments",
        "single assignment"
    ]);
    displayList($options);

    $index = readline(
        "Please enter the number to the left of the available resend option: "
    );

    try {
        return $options->get($index);
    } catch (\Throwable $e) {
        print red("Sorry that ${index} is an invalid option.  Please try again") . PHP_EOL . PHP_EOL;
        return userSelectsMonthOrSingleAssignmentOption();
    }
}
