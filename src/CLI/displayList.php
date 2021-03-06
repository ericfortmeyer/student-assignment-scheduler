<?php

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
