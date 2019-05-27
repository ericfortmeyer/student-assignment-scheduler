<?php

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

use \Ds\Vector;

function loadConfigurationFiles(Vector $config_filenames): Vector
{
    return $config_filenames->map(
        function (string $filename): array {
            return require $filename;
        }
    );
}
