<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

use \Ds\Vector;

function makeRequiredDirectories(array $required_directories)
{
    $RequiredDirectories = new Vector($required_directories);
    
    $make_dir = function (string $dir) {
        file_exists($dir) || mkdir($dir, 0770, true);
    };

    $RequiredDirectories->map($make_dir);
}
