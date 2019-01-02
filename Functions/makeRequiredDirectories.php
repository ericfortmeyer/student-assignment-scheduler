<?php

namespace StudentAssignmentScheduler\Functions;

use \Ds\Vector;

function makeRequiredDirectories(array $required_directories)
{
    $RequiredDirectories = new Vector($required_directories);
    
    $make_dir = function (string $dir) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . $dir;
        file_exists($path) || mkdir($path, 0770, true);
    };
    $RequiredDirectories->map($make_dir);
    
}
