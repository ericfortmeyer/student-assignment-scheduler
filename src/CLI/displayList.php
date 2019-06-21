<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

use \Ds\Map;

function displayList(iterable $list): void
{
    $Map = new Map($list);
    $Map->apply(
        function (int $key, string $value): void {
            print "(" . green("${key}") . ") ${value}" . PHP_EOL;
        }
    );
}
